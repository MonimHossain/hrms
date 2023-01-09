<?php

namespace App\Http\Forms;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

abstract class Form {

    use ValidatesRequests;

    protected $request;

    protected $rules = [];



    public function __construct(Request $request = null)
    {
        $this->request = $request ?: request();
    }

    protected function isValid()
    {
       /* try {
            $this->validate($this->request, $this->rules);
            return true;
        } catch (\Exception $e){
            throw new $e;
            return redirect()->route('admin.loan.setting.loan.type');
        }*/

        $this->validate($this->request, $this->rules);
        return true;
    }


    /* store method */
    abstract public function saveData();

    public function save()
    {
        //dd($this->request->all());

        if($this->isValid()) {
            $this->saveData();
            return true;
        }
        return false;
    }


    public function __get($property)
    {
        return $this->request->{$property};
    }


}
