<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Category;
use App\Book;
use App\User;
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
    
    public function getImage_guzzle($path){
        //Upload image to imgur and get an api
        $url = "https://api.imgur.com/3/image";
        $client_id = "ec059f02e935857";
        $client = new Client();
        $gRequest = new gRequest(
            'POST', $url, [
            "Authorization" => "Client-ID " . $client_id
            ], base64_encode(file_get_contents($path))
        );
        $gResponse = $client->send($gRequest, ['timeout' => 2]);
        return json_decode($gResponse->getBody()->getContents());
    }


    public function save_new_books(NewBookRequest $request)
    {
        $imagePath = $request->file('uploadImage')->getRealPath();
        $imgObj = $this->getImage_guzzle($imagePath);
        //Save to books table
        $book = new Book;
        $book->available = 1;
        $book->name = $request->name;
        $book->category_id = $request->category;
        $book->info = $request->info;
        $book->imgLink = $imgObj->data->link;
        $book->save();

        return redirect()->back()->with('status', 'Book added!');
    }
    
    public function show_books_list_page()
    {
        $categories = Category::all();
        return view('bookslist',compact('categories'));
    }
    
    public function get_books_json($category)
    {
        if ($category != 0) {
            return $books = Book::where('available', 1)->where('category_id', $category)->get()->toJson();
        } else {
            return $books = Book::where('available', 1)->get()->toJson();
        }
    }
    
    public function update_rent_books(Request $request)
    {      
        $data = json_decode($request->data);
        if(count($data) > 0){
            foreach ($data as $book_id) {
                $book = $this->set_available_book($book_id, 0);
                $this->user_rent_book(Auth::id(), $book);
            }
        }           
    }
    
    public function set_available_book($book_id,$available)
    {
        $book = Book::find($book_id);
        $book->available = $available;
        $book->save();
        return $book;
    }
    
    public function user_rent_book($user_id,Book $book)
    {
        $user = User::find($user_id);
        $user->books()->save($book);
    }
}
