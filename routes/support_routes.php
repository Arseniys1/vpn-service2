<?php

Route::group(['prefix' => '{locale}/support', 'middleware' => ['locale', 'auth']], function () {
    Route::get('/', 'Support\MyTicketsController@index')->name('cabinet.support.my_tickets');
    Route::get('/ticket/{id}', 'Support\TicketController@index')->name('cabinet.support.ticket');
    Route::post('/ticket/{id}/send/message', 'Support\TicketController@sendMessage')->name('cabinet.support.ticket.send.message');
    Route::get('/ticket/{id}/send/feedback/true', 'Support\TicketController@feedbackTrue')->name('cabinet.support.ticket.send.feedback.true');
    Route::get('/ticket/{id}/send/feedback/false', 'Support\TicketController@feedbackFalse')->name('cabinet.support.ticket.send.feedback.false');
    Route::get('/new/ticket', 'Support\NewTicketController@index')->name('cabinet.support.new.ticket');
    Route::post('/new/ticket', 'Support\NewTicketController@newTicket')->name('cabinet.support.new.ticket.post');
});