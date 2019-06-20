<?php


namespace App\Tenant;


class ManagerTenant
{
    public function getTenantIdentify()
    {
        //dd(auth()->user()->tenant->id);
        return auth()->user()->tenant->id;
    }
}
