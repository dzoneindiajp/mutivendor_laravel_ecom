@if($results->isNotEmpty())
@forelse($results as $product)
<tr class="list-data-row" data-total-count="{{$totalResults}}">
    <td>{{ $product->name ?? "N/A" }}</td>
    <td>{{ $product->slug ?? "N/A" }}</td>
    <td>
        {{ $product->category_name ?? "N/A" }}
    </td>
    <td>
        {{ $product->sub_category_name ?? "N/A" }}
    </td>
    <td>{{ $product->child_category_name ?? "N/A" }}</td>
    <td><img src="{{ !empty($product->frontProductImage->image) ? $product->frontProductImage->image  : config('constant.IMAGE_URL') . 'noimage.png' }}" height="70px" width="70px" style="border-radius: 10%"></td>
    <td>{{ $product->buying_price ?? 0 }}</td>
    <td>{{ $product->selling_price ?? 0 }}</td>
    <td>
        <input type="checkbox" class="in-stock-checkbox" data-product-id="{{ $product->id }}" {{ $product->in_stock ? 'checked' : '' }}>
    </td>
    <td>
        <input type="checkbox" class="is-featured-checkbox" data-product-id="{{ $product->id }}" {{ $product->is_featured ? 'checked' : '' }}>
    </td>
    <td>
        <div class="hstack gap-2 flex-wrap">
            <a href="{{ route('admin-product-view',['token' => encrypt($product->id)]) }}" class="btn btn-info"><i
                    class="ri-eye-line"></i></a>
            <a href="{{ route('admin-product-edit',['token' => encrypt($product->id)]) }}" class="btn btn-info"><i
                    class="ri-edit-line"></i></a>
            <form method="POST" action="{{ route('admin-product-delete',['token' => encrypt($product->id)]) }}">
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <button type="submit" class="btn btn-danger" id="confirm-button"><i
                        class="ri-delete-bin-5-line"></i></button>
            </form>
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