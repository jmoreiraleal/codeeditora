<?php

namespace CodePub\Models;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model implements TableInterface
{

    //trait que auxilia em tudo que preisa para exclusão lógica
    use SoftDeletes;

    //esse atributo configura o campo tipo data, para esse campo
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }


    /**
     * Method mutator
     * use nametrashed
     * @return mixed|string
     */
    public function getNameTrashedAttribute()
    {
        return $this->trashed() ? "{$this->name} (Inativa)" : $this->name;
    }

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        return ['#', 'Nome'];
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
            case 'Nome':
                return $this->name;

        }
    }

}
