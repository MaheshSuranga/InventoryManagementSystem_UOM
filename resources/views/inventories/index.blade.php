@extends('layouts.app')
@section('content')
    <h1>Inventories List</h1>
    <small style="color: red">**Only currently available inventories are displayed here</small>
    <?php $availability = 0; ?>
    @foreach($inventories as $inventory)
        @if($inventory->availability === 1)
            <?php $availability = 1; ?>
        @endif
    @endforeach
    <div class="form-group">
        <div class="col-md 8 col-sm-8">
            <i class="glyphicon glyphicon-search " style="float:right"></i>
        </div>
        <div class="col-md-4 col-sm-4">  
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="What you looking for?" class="form-control">
        </div>       
    </div>
    
    @if(count($inventories)>0 && $availability === 1)
        <table class="table table-striped table-hover" id="myTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventories as $inventory)               
                    <tr class="trInvent" data-href="/inventories/{{$inventory->id}}">                   
                        <td data-href='/'>{{$inventory->id}}</td>
                        <td data-href='/'>{{$inventory->name}}</td>
                        <td data-href='/'>{{$inventory->brand}}</td>
                        <td data-href='/'>{{$inventory->price}}</td>
                        <td data-href='/'>{{$inventory->description}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Currently No Inventories Available</p>
    @endif
    {{$inventories->links()}}
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('table.table').on("click", "tr.trInvent", function() {
        window.location = $(this).data("href");
        });
    });
</script>

<script>
    function myFunction(){
        let input, filter, table, tr, td,value, i, j;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByClassName('trInvent');


        for(i=0; i<tr.length; i++){
            td = tr[i].getElementsByTagName('td');
            //alert(td.length);
            for(j=0; j<td.length; j++){
                value = tr[i].getElementsByTagName('td')[j];
                //alert(value.innerHTML.toUpperCase().indexOf(filter));
                if(td){ 
                    if(value.innerHTML.toUpperCase().indexOf(filter)>-1){
                        tr[i].style.display = "";
                        break;
                    }else{
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    }    
</script>
