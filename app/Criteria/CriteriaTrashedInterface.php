<?php
namespace CodePub\Criteria;

interface CriteriaTrashedInterface{
    /**
     * traz apenas o lixo
     * @return mixed
     */
    public  function onlyTrashed();

    /**
     * traz os dados com o lixo
     * @return mixed
     */
    public  function withTrashed();
}