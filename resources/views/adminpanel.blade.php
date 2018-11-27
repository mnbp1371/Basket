<table border="1px">
@foreach($users as $user)

        <tr>
            <td>{{$user->id}} </td>
            <td>{{$user->name}} </td>

            <td>{{$user->email}} </td>
            <td>{{$user->created_at}} </td>
            <td>{{$user->created_at}} </td>
                <form action="/{{$user->id}}/indexstore" method="post">
                    {{csrf_field()}}
                    <td>
                        <select name="permission" >
                            <option value="1" @if($user->rol_id == 1) selected @endif >user1</option>
                            <option value="2" @if($user->rol_id == 2) selected @endif >user2</option>
                            <option value="3" @if($user->rol_id == 3) selected @endif >user3</option>
                        </select>
                    </td>
                    <td><input type="submit"></td>
                 </form>
            <td>
                <form action="/user/{{$user->urltitle}}" method="post">
                    {{csrf_field()}} {{method_field('delete')}}
                    <input type="submit" value="delete">
                </form>
            </td>

            <td> <a href="/{{$user->id}}/showposts"> show posts</a>  </td>
        </tr>



@endforeach
</table>
