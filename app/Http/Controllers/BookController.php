<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Book;
use App\Http\Requests\NewBookRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as gRequest;

class BookController extends Controller
{
    public function show_create_new_books_page()
    {
        $categories = Category::all();
        return view('createnewbooks', compact('categories'));
    }
    
    public function save_new_books(NewBookRequest $request)
    {
        //Upload image to imgur and get an api
        $url = "https://api.imgur.com/3/image";
        $client_id = "ec059f02e935857";
        $client = new Client();
        $gRequest = new gRequest(
            'POST',
            $url,
            [
                "Authorization" => "Client-ID " . $client_id
            ],
            base64_encode(file_get_contents($request->file('uploadImage')->getRealPath()))
        );
        $gResponse = $client->send($gRequest, ['timeout' => 2]);
        $imgLink = json_decode($gResponse->getBody()->getContents());
        //Save to books table
        $book = new Book;
        $book->available = 1;
        $book->name = $request->name;
        $book->category_id = $request->category;
        $book->info = $request->info;
        $book->imgLink = $imgLink->data->link;
        $book->save();

        return redirect()->back()->with('status', 'Book added!');
    }
}
