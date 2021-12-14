@extends('layout')
   
@section('content')

<div style="padding:30px"></div>
<div class="row">
    <div class="col-sm-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">STUDENT List</h5>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Sl</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              {{-- <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>photo</td>
                <td><a class="btn btn-success" href="">Edit</a><a class="btn btn-danger" href="">Delete</a></td>
              </tr> --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>

 <div class="col-md-5">
    <form method="post" class="FrmUpdate" id="FrmUpload" enctype="multipart/form-data">
        @csrf
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label"> Name</label>
                  <input type="text" id="name" name="name" placeholder="name"class="form-control">
                  <span class="text-danger" id="nameError"> </span>
              </div>
    
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Description</label>
                  <textarea class="form-control" name="description" id="description" cols="100" rows="3"></textarea>
                  <span class="text-danger" id="emailError"> </span>
              </div>

              <input type="hidden" id="id" name="id">
    
              <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Image</label>
                  <input type="file" class="form-control" id="image" name="image" aria-describedby="photoHelp">
                  <span class="text-danger" id="photoError"> </span>
              </div>

            <div class="row" id="newImg">
                <div class="col-md-8">
                     <strong>Original Image:</strong>
                     <br/>
                     <img id="ImgOri" src=""  height="100px" width="300px"/>
               </div>
          </div>

              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label"> Price</label>
                <input type="number" id="price" name="price" class="form-control">
                <span class="text-danger" id="nameError"> </span>
            </div>

            <button  id="Upload" type="submit"  class="btn btn-primary">Upload</button>
            <button  id="Update" type="submit"  class="btn btn-primary">Update</button>
        
       </form>
</div>


   <script>

    $.ajaxSetup({
        headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#newImg').hide();
    $('#Update').hide();

   function allProducts(){
       $.ajax({
           type:"GET",
           dataType:"json",
           url:"product/all",
           success:function(response){
            $('tbody').html("");
          $.each(response, function(key, item){
            $('tbody').append('<tr>\
                        <td>'+item.id+'</td>\
                        <td>'+item.name+'</td>\
                        <td>'+item.description+'</td>\
                        <td><img src="'+item.image+'"width="50px" height="50px" alt="Image"></td>\
                        <td>'+item.price+'</td>\
                        <td><button type="button" class="edit_btn btn btn-success" onclick="editData('+item.id+')">Edit</button></td>\
                        <td><button type="button" value="" class="delete_btn btn btn-danger btn-sm">Delete</button></td>\
                      </tr>');
          });
           }
       });
   }

   allProducts();


$('#Upload').on("click", function() {
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
                    alert('data updated successfully');
                }

            });
    });
});


function editData(id){
    $.ajax({
               type:"GET",
               dataType:"json",
               url: "product/edit/"+id,
               success:function(data){
                    $('#newImg').show();
                    $('#Update').show();
                    $('#Upload').hide();

                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#image').val(data.image);
                    $('#price').val(data.price);
                    $('#ImgOri').attr('src',data.image);
               }
           })
}


$('#Update').on("click", function() {
    // alert('check');
$('form').submit(function(e){
            e.preventDefault();
            var formData=new FormData(this);
            $.ajax({
                type:"POST",
                dataType:"json",
                url:"product_Update_db",
                data:formData,
                contentType: false,
                processData: false,
                success:function(data){
                    alert('data Update successfully');
                }

            });
    });
});

 
                       
   </script>

    @endsection