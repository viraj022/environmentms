<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserNotificationsRepositary;

class UserNotificationsController extends Controller
{

    protected $userNotificationRepository;

    public function __construct(UserNotificationsRepositary $userNotificationRepository)
    {
        $this->userNotificationRepository = $userNotificationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $message = $request->message;
        $client_id = $request->client_id;

        $user_id = auth()->user()->id;
        $this->userNotificationRepository->makeNotification($user_id, $message, $client_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserNotifications  $userNotifications
     * @return \Illuminate\Http\Response
     */
    public function show(UserNotifications $userNotifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserNotifications  $userNotifications
     * @return \Illuminate\Http\Response
     */
    public function edit(UserNotifications $userNotifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserNotifications  $userNotifications
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserNotifications $userNotifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserNotifications  $userNotifications
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserNotifications $userNotifications)
    {
        //
    }
}
