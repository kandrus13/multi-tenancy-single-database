<?php

namespace App\Rules\Tenant;

use App\Tenant\ManagerTenant;
use DB;
use Illuminate\Contracts\Validation\Rule;

class TenantUnique implements Rule
{
    private $table;
    private $colunm;
    private $colunmValue;


    /**
     * TenantUnique constructor.
     * @param $table
     * @param  null  $colunmValue
     * @param  string  $colunm
     */
    public function __construct($table, $colunmValue = null, $colunm = 'id')
    {
        $this->table = $table;
        $this->colunm = $colunm;
        $this->colunmValue = $colunmValue;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $tenant = app(ManagerTenant::class)->getTenantIdentify();
        $result = DB::table($this->table)
            ->where($attribute, $value)
            ->where('tenant_id', $tenant)
            ->first();

        if ($result && $result->{$this->colunm} == $this->colunmValue) {
            return true;
        }

        return is_null($result);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "O titulo já está em uso!!!";
    }
}
