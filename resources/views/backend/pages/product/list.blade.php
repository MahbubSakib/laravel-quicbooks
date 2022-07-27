<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" src="{{ asset('css') }}/app.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js')}}"></script>

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <div style="padding: 30px"></div>
    <div class="container">
        <h2>Laravel Ajax</h2>
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        Product
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Volume</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <span id="addP">Add Product</span>
                        <span id="updateP">Update Product</span>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Product Name</label>
                              <input type="" class="form-control" id="product_name" aria-describedby="emailHelp" placeholder="Enter product name">                    </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Category</label>
                              <input type="" class="form-control" id="category" placeholder="Category">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Total Item</label>
                                <input type="" class="form-control" id="product_item" placeholder="Item number">
                              </div>
                            <button type="submit" id="addProduct" onclick="addData()" class="btn btn-primary">Add</button>
                            <button type="submit" id="updateProduct" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#addP').show();
        $('#updateP').hide();
        $('#addProduct').show();
        $('#updateProduct').hide();

        $.ajaxSetup({
          headers:{
            'X-CSRF-TOKEN': $("meta[name= 'csrf-token']").attr('content')
          }
        })

        function allData(){

          $.ajax({
            type: "GET",
            dataType: 'json',
            url: "all",

            success:function(response){
              var data = ""
              
              $.each(response, function(key, value){
                data = data + "<tr>"
                  data = data + "<td>"+value.id+"</td>"
                  data = data + "<td>"+value.product_name+"</td>"
                  data = data + "<td>"+value.category+"</td>"
                  data = data + "<td>"+value.product_volume+"</td>"
                  data = data + "<td>"
                  data = data + "<button type='button' class='btn btn-primary mr-2'>Edit</button>"
                  data = data + "<button type='button' class='btn btn-danger'>Delete</button>"
                  data = data + "</td>"
                data = data + "</tr>"
              })
              $('tbody').html(data);
            }
          })
        }
        allData();


        function addData(){
          // var product_name = $('#product_name').val();
          // var category     = $('#category').val();
          // var product_item = $('#product_item').val();
          // console.log(product_name);
          // console.log(category);
          // console.log(product_item);
          console.log('hi');

          // $.ajax({
          //   type:'POST',
          //   datatType:'json',
          //   data: {product_name: product_name, category: category, product_item: product_item},
          //   url: 'store',
          //   success:function(data){
          //     console.log('data added');
          //   }
          // })
        }

    </script>
</body>
</html>