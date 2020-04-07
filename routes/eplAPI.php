<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::middleware('auth:api')->post('/epl', 'EPLController@create'); //   save attachements to a application
    
    /*
   {
    "name": "hcw coporatio65",
    "client_id":"1",
    "industry_category_id": "5",
    "business_scale_id": "1",
    "contact_no": "0710576923",
    "address": "Nakkawatta",
    "email": "hansanacham@gmail.com",
    "coordinate_x": "60",
    "coordinate_y": "50",
    "pradesheeyasaba_id": "10",
    "is_industry": "1",(yes=1,no=0)
    "investment": "500000",
    "start_date": "2020-01-01",
    "registration_no": "13212721",
    "remark": "abc",
    "file": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAIAAAB7GkOtAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQA
    APoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAABmJLR0QA/wD/AP+gvaeTAAAAB3RJTUUH5AMWBjULQr3mKwAAXc5JREFUeNrt/Wd3HFeC7vn+IyIjIr1B
    JjxIgN4b+apSVamru+/06XPvrDUfqT7UzDpn+vRMV3UZeUfvHbzJRHoT9r7IBAlQlJqSoCKoen4Li4uCQkAqMnI/228jjmNEROTvj6lbICKiABAREQWAiIgo
    AERERAEgIiIKABERUQCIiIgCQEREFAAiIqIAEBERBYCIiCgAREREASAiIgoAERFRAIiIiAJAREQUACIiogAQEREFgIiIKABEREQBICIiCgAREVEAiIiIAkBER
    AEgIiIKABERUQCIiIgCQEREFAAiIqIAEBERBYCIiCgAREREASAiIgoAERFRAIiIiAJAREQUACIiogAQEREFgIiIKABEREQBICIiCgAREVEAiIiIAkBERBQAIi
    KiABAREQWAiIgCQEREFAAiIqIAEBERBYCIiCgAREREASAiIgoAERFRAIiIiAJAREQUACIiogAQEREFgIiIKABEREQBICIiCgAREVEAiIiIAkBERBQAIiKiABAR
    EQWAiIgoAERERAEgIiIKABERUQCIiCgAREREASAiIgoAERFRAIiIiAJAREQUACIiogAQEREFgIiIKABEREQBICIiCgAREVEAiIiIAkBERBQAIiKiABAREQWAiI
    goAERERAEgIiIKABERUQCIiIgCQEREFAAiIqIAEBFRAIiIiAJAREQUACIiogAQEREFgIiIKABEREQBICIiCgAREVEAiIiIAkBERBQAIiKiABAREQWAiIgoAERER
 
'id' => 1, 'message' => 'true', 'rout' => '/epl_profile/clien/1/profile/12
}
    */