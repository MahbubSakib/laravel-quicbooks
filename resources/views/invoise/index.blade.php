<style>
    table, th, td {
      padding: 5px;
    }
    table {
      border-spacing: 15px;
    }
</style>
<table>
    <thead>
        <tr>
            <th>
                Invoice Id
            </th>
            <th>
                Created
            </th>
            <th>
                Detail Type
            </th>
            <th>
                Action
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoice as $key)
            <tr>
                <td>
                    {{$key->Id}}
                </td>
                <td>
                    {{ Carbon\Carbon::parse($key->MetaData->CreateTime)->format('Y-m-d') }}
                </td>
                <td>
                    {{-- @if(isset($key->Line))
                        {{$key->Line->Id}}
                    @endif --}}
                    @foreach($key->Line as $value)
                    {{-- @foreach($value->) --}}
                        @if(isset($value->Id))
                            {{$value->SalesItemLineDetail->TaxCodeRef}}
                        @endif
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('invoice', $key->Id) }}">
                        Show
                    </a>
                    <a href="{{ route('delete', $key->Id) }}">
                        Delete
                    </a>    
                </td>ss
            </tr>
        @endforeach
    </tbody>
</table>