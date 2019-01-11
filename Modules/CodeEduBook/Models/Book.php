<?php

namespace CodeEduBook\Models;

use Bootstrapper\Interfaces\TableInterface;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\DetectsLostConnections;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;


/**
 * Class Book.
 *
 * @package namespace CodePub\Models;
 */
class Book extends Model implements TableInterface
{
    use FormAccessible;
    //trait que auxilia em tudo que preisa para exclusão lógica
    use SoftDeletes;

    protected  $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'subtitle',
        'price',
        'author_id'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        //Método withtrashed traz as categorias excluídas que tem relação com o livro
        return $this->belongsToMany(Category::class)->withTrashed();
    }

    /**
     * @return mixed
     */
    public function formCategoriesAttribute()
    {
        return $this->categories->pluck('id')->all();
    }

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        return ['#','Título','Autor','Preço'];
    }

    /**
     * Get the value for a given header. Note that this will be the value
     * passed to any callback functions that are being used.
     *
     * @param string $header
     * @return mixed
     */
    public function getValueForHeader($header)
    {
        switch ($header){
            case '#':
                return $this->id;
            case 'Título':
                return $this->title;
            case 'Autor':
                return $this->author->name;
            case 'Preço':
                return $this->price;
        }
    }

}
