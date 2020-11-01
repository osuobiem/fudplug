<select name="area" class="form-control" required>
    @foreach($areas as $key=>$val)
    @if($user_location->area_id == $val->id)
    <option value="{{$val->id}}" selected>{{$val->name}}</option>
    @else
    <option value="{{$val->id}}">{{$val->name}}</option>
    @endif
    @endforeach
</select>
