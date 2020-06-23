<?php

namespace Unite\UnisysApi\Modules\Settings\Http\Controllers;

use Unite\UnisysApi\Http\Controllers\UnisysController;
use Unite\UnisysApi\Modules\Settings\Contracts\Settings;
use Unite\UnisysApi\Modules\Settings\Http\Requests\ModifySettingRequest;

abstract class SettingController extends UnisysController
{
    /** @var Settings */
    protected $settings;

    public function __construct()
    {
        $this->settings = app($this->getSettingClass());
    }

    protected abstract function getSettingClass()
    : string;

    public function list()
    {
        return jsonResponse($this->settings->getConfig());
    }

    public function create(ModifySettingRequest $request)
    {
        $this->settings->createNew($request->get('key'), $request->get('value'), $request->get('encrypt'));

        successJsonResponse();
    }

    public function update(ModifySettingRequest $request)
    {
        $this->settings->updateByKey($request->get('key'), $request->get('value'), $request->get('encrypt'));

        return successJsonResponse();
    }

    public function delete(ModifySettingRequest $request)
    {
        $this->settings->deleteByKey($request->get('key'));

        return successJsonResponse();
    }
}
