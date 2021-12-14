@extends('layout')
   
@section('content')

<form method="post" id="FrmUpload" enctype="multipart/form-data">
    @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label"> Name</label>
              <input type="text" id="name" name="name" placeholder="name"class="form-control">
              <span class="text-danger" id="nameError"> </span>
          </div>

            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Description</label>
              <textarea class="form-control" name="description" id="description" cols="100" rows="5"></textarea>
              <span class="text-danger" id="emailError"> </span>
          </div>

          <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Image</label>
              <input type="file" class="form-control" id="image" name="image" aria-describedby="photoHelp">
              <span class="text-danger" id="photoError"> </span>
          </div>

          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"> Price</label>
            <input type="text" id="price" name="price" placeholder="price"class="form-control">
            <span class="text-danger" id="nameError"> </span>
        </div>
        <button  id="Upload" type="submit" id="submit" class="btn btn-primary">Upload</button>
    
   </form>



   <script>

    $.ajaxSetup({
        headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    }) ;  

    $('form').submit(function(e){
            e.preventDefault();
            var formData=new FormData(this);
            
            $.ajax({
                type:"POST",
                dataType:"json",
                url:"product_add_db",
                data:formData,
                contentType: false,
                processData: false,
                success:function(data){
                    alert('data add successfully');
                }

            });
    });

 
              
                
   </script>

    @endsection