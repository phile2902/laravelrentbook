@extends('layouts.app')

@section('content')
<?php
    $count = 1;
?>

<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <p>Name : {{$user->name}}</p>
            <p>Email: {{$user->email}}</p>
        @if($user->id == Auth::user()->id)
            <input class='btn btn-info' type="button" name="returnBooks" value="Return"/>
        </div>
        <div class="col-lg-9 rentBook">
            <h2>Rent Books</h2>
            <table class="table table-bordered">
                <thead>
                <th class="col-lg-1">#</th>
                <th class="col-lg-3">Image</th>
                <th class="col-lg-3">Name</th>
                <th class="col-lg-4">Info</th>
                <th class="col-lg-4">Return</th>
                </thead>
                <tbody class="bookBody">
                    @foreach($books as $book)
                    <tr>
                        <td>{{$count++}}</td>
                        <td>
                            <img src="{{$book->imgLink}}" class="img-responsive" alt="Responsive image">
                        </td>
                        <td>{{$book->name}}</td>
                        <td>{{$book->info}}</td>
                        <td class="text-center">
                            <input type="checkbox" name="returnbookcheckbox" value='{{$book->id}}' />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        </div>
        <div class="col-lg-9 rentBook">
            <h2 class="text-center">You can not see the other's rent books.</h2>
        </div>
        @endif
    </div>
    
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //Handle event return button
        $('input[name="returnBooks"]').on('click', function () {
            if ($('.bookBody tr').length > 0) {
                var arrayBookId = [];

                $('.bookBody  > tr').each(function ($row) {
                    var bookID = $(this).find('input[name="returnbookcheckbox"]:checked').val();
                    if (typeof bookID !== "undefined") {
                        arrayBookId.push(bookID);
                    }
                });
                //Save books to User
                if (!jQuery.isEmptyObject(arrayBookId)) {
                    $.ajax({
                        url: "returnBooks",
                        method: "POST",
                        data: {data: JSON.stringify(arrayBookId)},
                        cache: false
                    })
                    .done(function (data) {
                        location.reload();
                    })
                    .fail(function (jqXHR, textStatus) {
                        alert("Request failed: " + textStatus);
                    });
                } else {
                    alert("You don't select books to return yet");
                }
            }
        });

    });
</script>
@endsection



