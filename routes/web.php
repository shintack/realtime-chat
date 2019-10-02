<?php

use App\Message;
use App\Events\MessageSent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Return all messages that will populate our chat messages
Route::get('/getAll', function () {
    $messages = Message::take(200)->pluck('content');
    return $messages;
});

// Allows us to post new message
Route::post('/post', function () {
    $message = new Message();
    $content = request('message');
    $message->content = $content;
    $message->save();

    event(new MessageSent($content));

    return $content;
});

Route::get('/embed', function () {
    header('Access-Control-Allow-Origin: *');
    return '
    <style>
        #chat-container{
            background-color:pink;
            line-height:50px;
            text-align:center;
            border-radius:20px;
            min-width: 200px;
            min-height:50px;
            position: fixed;
            bottom: 10px;
            right: 10px;
            cursor:pointer;
        }
        #frame-chat{
            display:none; border:none; width: 500px; height:400px; position: fixed; bottom: 0; right: 0;
        }
        #open-chat{
            display: block;
        }
        #close-chat{
            display: none;
        }
    </style>
    <script>

    </script>

    <div id="chat-container">
    <span onclick="openChat()" id="open-chat"> CHAT </span>
    <span onclick="closeChat()" id="close-chat"> CLOSE CHAT </span>
    <iframe id="frame-chat" src="http://localhost:8000"></iframe></div>

    ';
});

Auth::routes();


Route::group(['middleware' => ['auth']], function () {

    Route::get('/my-profile', 'UserController@myProfile')->name('my-profile');


    Route::get('/', 'ChatController@index')->name('chat-app');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/chat', 'ChatController@index');
    });

    Route::get('chat-all', 'ChatController@chanelsAll')->name('all-channel');

    Route::group(['prefix' => 'chat'], function () {
        Route::get('/', 'ChatController@index')->name('chat');
        // Route::get('/all', 'ChatController@index')->name('chat-all');
        Route::post('/', 'ChatController@store');
        Route::delete('/{id}', 'ChatController@destroy');
        // Route::get('/{id}', 'ChatController@show')->name('chat');
        Route::get('/chanels', 'ChatController@chanels')->name('chanels');
    });

    Route::group(['prefix' => 'message'], function () {
        Route::get('/{id}', 'ChatController@getMessage')->name('get-message');
        Route::post('/{id}', 'ChatController@saveMessage')->name('send-message');
    });
});
