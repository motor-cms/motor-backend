<?php

namespace Motor\Backend\Http\Requests\Backend;

use Illuminate\Validation\Rule;
use Motor\Backend\Http\Requests\Request;

/**
 * Class CategoryTreeRequest
 */
class CategoryTreeRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="CategoryTreeRequest",
     *
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="New category tree"
     *   ),
     *   @OA\Property(
     *     property="scope",
     *     type="string",
     *     example="new-category-scope"
     *   ),
     *   required={"name", "scope"},
     * )
     */

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $request = $this;

        return [
            'name' => 'required',
            'scope' => [
                'required',
                Rule::unique('categories')
                    ->where(function ($query) use ($request) {
                        if ($request->method() == 'PATCH' || $request->method() == 'PUT') {
                            return $query->where('scope', $request->scope)
                                ->where('parent_id', null)
                                ->where('id', '!=', $request->route()
                                    ->originalParameter('category'));
                        } else {
                            return $query->where('scope', $request->scope)
                                ->where('parent_id', null);
                        }
                    }),
            ],
        ];
    }
}
