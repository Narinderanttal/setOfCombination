@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

            
            </div>
        </div>
    </div>
</div>
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
@if (Session::has('messages'))
    <div class="alert alert-danger">{{ Session::get('messages') }}</div>
@endif
<div class="container">
    <br>
    <br>
    <form>
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Set Of Combination</label>
                    <input type="number" id="num" class="form-control" onkeyup="combinations(this.value)">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" id="amounts" class="form-control" onkeyup="amount(this.value)">
                </div>
            </div>
            <!-- <button type="button" id="display" class="btn btn-sm btn-primary">Display</button> -->
        </div>
    </form>
    <br>
    <br>
    <div class = "row mt-3">
        <div class = "col-md-12">
            <form method="post" action="{{ url('/add-combination') }}">
                <table class = "table">
                
                    @csrf
                    <tbody class="append_data" >
                        <!-- <tr>
                            <td class = "tdContent">
                                <input type = "text" class = "form-control"/>
                            </td>
                            <td class = "tdContent">
                                <input type = "text" class = "form-control"/>
                            </td>
                        </tr> -->
                        <button type="submit" class="btn btn-sm btn-primary">save</button>
                    </tbody>
                
                </table>  
            </form>  
        </div>
    </div>
</div>

<script>
    function combinations(num) 
    {
        var amount = document.getElementById("amounts").value;
        var values =  num.toString().replace(/\B(?=(\d{1})+(?!\d))/g, ",");

        $.ajax({
            type:'POST',
            url: "{{ url('get-combination') }}",
            data: {_token:"{{csrf_token()}}",value:values},
            success: (response) => {
                console.log("========",response);
               
                if (response.length>0) 
                {
                    $(".append_data").empty();
                    for (var i=0; i < response.length; i++) 
                    {   
                        var totalamount = parseInt(response[i]) * parseInt(amount);  
                        $(".append_data").append('<tr><td class="tdContent"><input type="number" name="numb'+i+'" class= "form-control" id="numb'+i+'" value="'+response[i]+'"/></td><td class="tdContent"><input type="number"name="getamount"  id="getamount" value="" class="form-control getamount"/></td><td class="tdContent"><input type="text" name="totalamount'+i+'" class="form-control totalamount" value="'+totalamount+'"/></td></tr><input type="hidden"name="count" value="'+response.length+'" class="form-control"/>');
                    }
                    x=document.getElementsByClassName("getamount");
                    for (i = 0; i < x.length; i++) 
                    {
                        x[i].value=amount;
                    }
                }
                else
                {
                    $(".append_data").empty();
                }
            },
            error: function(response){
                console.log(response);
            }
        });
    }
    function amount(amt) 
    {
        x=document.getElementsByClassName("getamount");
        y=document.getElementsByClassName("totalamount");
        
		for (i = 0; i < x.length; i++) 
        {
            x[i].value=amt;
            amounts = document.getElementById("numb"+i).value;
            
            y[i].value = parseInt(amt) * parseInt(amounts);
            // console.log('===',x[i]);
            // console.log('====',amounts);
        }
    }
</script>
@endsection

