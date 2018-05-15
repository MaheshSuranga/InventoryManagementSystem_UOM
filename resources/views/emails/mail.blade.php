<ul>
    @foreach($inventories as $inventory)
        <li>{{$inventory->id}}  {{$inventory->name}}</li>
    @endforeach
</ul>
<br><br>
<p>Above these inventories are requested to borrow by <span><strong>{{$name}} ({{$index}})</strong></span></p><br>
<p>Please send email to me by mentioning whether you accept or not this request</p>

