<?php

namespace Motor\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

/**
 * Motor\Backend\Models\Language
 *
 * @property int                             $id
 * @property string                          $iso_639_1
 * @property string                          $english_name
 * @property string                          $native_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language filteredBy(\Motor\Core\Filter\Filter $filter, $column )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language filteredByMultiple(\Motor\Core\Filter\Filter $filter )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language search( $q, $full_text = false )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language whereEnglishName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language whereIso6391( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language whereNativeName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\Language whereUpdatedAt( $value )
 * @mixin \Eloquent
 */
class Language extends Model
{

    use Searchable;
    use Filterable;

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [ 'iso_639_1', 'native_name', 'english_name' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso_639_1',
        'english_name',
        'native_name',
    ];
}
