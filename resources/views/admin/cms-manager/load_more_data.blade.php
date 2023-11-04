@if($results->isNotEmpty())
@forelse($results as $result)
<tr class="list-data-row" data-total-count="{{$totalResults}}">

    <td>{{ $result->page_name ?? "N/A" }}</td>
    <td>
        {{ $result->page_name ?? "N/A" }}
    </td>
    <td>
        {!! strip_tags(Str::limit($result->body, 300)) !!}
    </td>
    <td>{{ date("Y-m-d" ,strtotime($result->created_at)) }}</td>
    

    <td>
        <div class="hstack gap-2 flex-wrap">
            <a href="{{route('admin-cms-manager.edit',base64_encode($result->id))}}" class="btn btn-info"><i
                    class="ri-edit-line"></i></a>

        </div>
    </td>
</tr>
@empty
@endforelse
@else
<tr class="noresults-row">
    <td colspan="7" style="text-align: center;">No results found.</td>
</tr>
@endif