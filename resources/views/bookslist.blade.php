@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <h1>List of Available Books</h1>
        
        <div class="row">
            <div class="col-lg-5 ">
                <select class="form-control category">
                    <option value="0">All</option>
                   @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                   @endforeach
                </select>
            </div>
        </div>
        </br>
        <div class="row">
            <div class="col-lg-10">
                <table class="table table-bordered">
                    <thead>
                        <th class="col-lg-1">#</th>
                        <th class="col-lg-3">Image</th>
                        <th class="col-lg-3">Name</th>
                        <th class="col-lg-4">Info</th>
                        <th class="col-lg-4">Rent</th>
                    </thead>
                    <tbody class="bookBody">

                    </tbody>
                </table>
            </div>
            
            <div class="col-lg-2">
                <input class='btn btn-info' type="button" name="addtostore" value="Add to my store"/>
            </div>
        </div>
        
    </div>

@endsection

@section('script')
<script>
    $( document ).ready(function() {
        function callAvailableBooks($cate){
            $.ajax({
                url: "getBooksByCate/" + $cate,
                method: "GET",
                cache: false
            })
            .done(function( data ) {
                data = jQuery.parseJSON(data);
                $('.bookBody').html('');
                $.each(data, function( index, obj ) {
                    var image = '<img src="'+obj.imgLink+'" class="img-responsive" alt="Responsive image">';
                    var $content = "<tr><td>"+(index+1)+"</td><td>"+image+"</td><td>"+obj.name+"</td><td>"+obj.info+"</td>" +
                    '<td class="text-center"><input type="checkbox" name="rentBook" value="'+obj.id+'"></td></tr>';
                    $('.bookBody').append($content);
                });

            })
            .fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        }
        var $selectCategory = 0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        callAvailableBooks($selectCategory);
        //Handle event select category
        $('.category').on('click',function(){
            var $val = $(this).find('option:selected').val();
            if($val == $selectCategory) {
                return;
            } else {
                $selectCategory = $val;
            }
            callAvailableBooks($selectCategory);
        });

        //Handle event add to store button
        $('input[name="addtostore"]').on('click', function () {
            if ($('.bookBody tr').length > 0) {
                var arrayBookId = [];

                $('.bookBody  > tr').each(function ($row) {
                    var bookID = $(this).find('input[name="rentBook"]:checked').val();
                    if (typeof bookID !== "undefined") {
                        arrayBookId.push(bookID);
                    }
                });
                //Save books to User
                if (!jQuery.isEmptyObject(arrayBookId)) {
                    $.ajax({
                        url: "updateRentBook",
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
                    console.log('No books selected yet');
                }
            }
        });

    });
</script>
@endsection
