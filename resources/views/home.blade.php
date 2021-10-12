@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="float-right">
                <div class="btn btn-success" data-toggle="modal" data-target="#addModal">Add</div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <form action="{{ url('/') }}" method="GET" class="form-inline">
                <div class="input-group mb-2 mr-sm-2">
                    <input type="text" class="form-control" name="search" placeholder="Search">
                    <div class="input-group-prepend">
                        <!-- <div class="input-group-text">@</div> -->
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
                <a href="{{ url('/') }}" class="btn btn-secondary mb-2">Reset</a>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        @foreach($items as $item)
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">
                    {{ $item->name }}
                    <div class="float-right">
                        <form action="{{ url('/') }}" method="post" class="form-inline">
                            @method('DELETE')
                            @csrf
                            <span class="btn btn-warning btn-sm mr-1 edit" data-id="{{ $item->id }}">e</span>
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <div>
                                <input type="submit" onclick="confirm('Are you sure?')" class="btn btn-danger btn-sm" value="x">   
                            </div>
                        </form>
                        
                    </div>
                </div>

                <div class="card-body">
                    <div>
                        <img src="{{ $item->path }}" alt="example" style="height: 100%; width: 100%; object-fit: contain;">
                    </div>
                    <div>
                        <table>
                            <tr>
                                <td>Buy Price</td>
                                <td>:</td>
                                <td class="pl-2">Rp {{ number_format($item->buyprice, 0, ",", ".") }}</td>
                            </tr>
                            <tr>
                                <td>Sell Price</td>
                                <td>:</td>
                                <td class="pl-2">Rp {{ number_format($item->sellprice, 0, ",", ".") }}</td>
                            </tr>
                            <tr>
                                <td>Stock</td>
                                <td>:</td>
                                <td class="pl-2">{{ $item->stock }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row justify-content-center">
    {{ $items->links() }}
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" placeholder="Enter Item Name">
            </div>
            <div class="form-group">
                <label for="buyprice">Buy Price</label>
                <input type="number" class="form-control" id="buyprice" name="buyprice" aria-describedby="buypriceHelp" placeholder="Enter Buy Price">
            </div>
            <div class="form-group">
                <label for="sellprice">Sell Price</label>
                <input type="number" class="form-control" id="sellprice" name="sellprice" aria-describedby="sellpriceHelp" placeholder="Enter Sell Price">
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" aria-describedby="stockHelp" placeholder="Enter Stock">
            </div>
            <div class="form-group">
                <label for="path">Image</label>
                <input type="file" class="form-control" id="path" name="path" aria-describedby="pathHelp" accept="image/png, image/jpeg">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>   
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/') }}" method="post" enctype="multipart/form-data" id="itemForm">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="form-group">
                <label for="editname">Item Name</label>
                <input type="hidden" name="id" id="id">
                <input type="text" class="form-control" id="editname" name="name" aria-describedby="nameHelp" placeholder="Enter Item Name">
            </div>
            <div class="form-group">
                <label for="editbuyprice">Buy Price</label>
                <input type="number" class="form-control" id="editbuyprice" name="buyprice" aria-describedby="buypriceHelp" placeholder="Enter Buy Price">
            </div>
            <div class="form-group">
                <label for="editsellprice">Sell Price</label>
                <input type="number" class="form-control" id="editsellprice" name="sellprice" aria-describedby="sellpriceHelp" placeholder="Enter Sell Price">
            </div>
            <div class="form-group">
                <label for="editstock">Stock</label>
                <input type="number" class="form-control" id="editstock" name="stock" aria-describedby="stockHelp" placeholder="Enter Stock">
            </div>
            <div class="form-group">
                <label for="path">Image</label>
                <input type="file" class="form-control" id="path" name="path" aria-describedby="pathHelp" accept="image/png, image/jpeg">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>   
    </div>
  </div>
</div>
<script>
    $('.edit').click(function(e){
        var id = $(this).data('id');
        $.ajax({
            url: "/"+id,
                    type: 'get', // replaced from put
                    dataType: "JSON",
                    success: function (response)
                    {
                        $('#itemForm').trigger('reset');
                        
                        $('#editname').val(response.name);
                        $('#id').val(response.id);
                        $('#editbuyprice').val(response.buyprice);
                        $('#editsellprice').val(response.sellprice);
                        $('#editstock').val(response.stock);
                        
                        $('#editModal').modal('show');
                    },
                    error: function(response) {
                        console.log(response); // this line will save you tons of hours while debugging
                        // do something here because of error
                    }
        });
    });
</script>
@endsection
