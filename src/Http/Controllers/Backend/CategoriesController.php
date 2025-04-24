<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Kalnoy\Nestedset\NestedSet;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Forms\Backend\CategoryForm;
use Motor\Backend\Grids\CategoryGrid;
use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\CategoryRequest;
use Motor\Backend\Models\Category;
use Motor\Backend\Services\CategoryService;
use Motor\Core\Filter\Renderers\WhereRenderer;

/**
 * Class CategoriesController
 */
class CategoriesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \ReflectionException
     */
    public function index(Category $record)
    {
        $grid = new CategoryGrid(Category::class);
        $grid->setSorting(NestedSet::LFT, 'ASC');

        $service = CategoryService::collection($grid);

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('scope'))
            ->setValue($record->scope);
        $filter->add(new WhereRenderer('parent_id'))
            ->setOperator('!=')
            ->setAllowNull(true)
            ->setValue(null);

        $grid->setFilter($filter);
        $paginator = $service->getPaginator();

        return view('motor-backend::backend.categories.index', compact('paginator', 'grid', 'record'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Category $root)
    {
        $form = $this->form(CategoryForm::class, [
            'method' => 'POST',
            'route' => 'backend.categories.store',
            'enctype' => 'multipart/form-data',
        ]);

        $trees = Category::where('scope', $root->scope)
            ->defaultOrder()
            ->get()
            ->toTree();
        $newItem = true;
        $selectedItem = null;

        return view('motor-backend::backend.categories.create', compact('form', 'trees', 'newItem', 'selectedItem', 'root'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CategoryRequest $request)
    {
        $form = $this->form(CategoryForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $record = CategoryService::createWithForm($request, $form)
            ->getResult();

        $root = $record->ancestors()
            ->get()
            ->first();

        flash()->success(trans('motor-backend::backend/categories.created'));

        return redirect('backend/categories/'.$root->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $record)
    {
        $root = $record->ancestors()
            ->get()
            ->first();

        $trees = Category::where('scope', $root->scope)
            ->defaultOrder()
            ->get()
            ->toTree();

        $form = $this->form(CategoryForm::class, [
            'method' => 'PATCH',
            'url' => route('backend.categories.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model' => $record,
        ]);

        $newItem = false;
        $selectedItem = $record->id;

        return view('motor-backend::backend.categories.edit', compact('form', 'trees', 'root', 'newItem', 'selectedItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CategoryRequest $request, Category $record)
    {
        $form = $this->form(CategoryForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $record = CategoryService::updateWithForm($record, $request, $form)
            ->getResult();

        $root = $record->ancestors()
            ->get()
            ->first();

        flash()->success(trans('motor-backend::backend/categories.updated'));

        return redirect('backend/categories/'.$root->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Category $record)
    {
        $root = $record->ancestors()
            ->get()
            ->first();

        CategoryService::delete($record);

        flash()->success(trans('motor-backend::backend/categories.deleted'));

        return redirect('backend/categories/'.$root->id);
    }
}
