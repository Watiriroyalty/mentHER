<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\BotManServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BotManController extends Controller
{
    /**
     * Handle incoming messages from the chatbot.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        // Create a new instance of BotMan
        $config = config('botman');
        $botman = BotManFactory::create($config, app(BotManServiceProvider::class));

        // Set up message handling logic
        $botman->hears('hello', function (BotMan $bot) {
            $bot->reply('Hi there!');
        });

        // Add more conversation logic as needed

        // Listen for incoming messages
        $botman->listen();

        // Return an empty response (important for certain messaging platforms)
        return new Response();
    }
}
