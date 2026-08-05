<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th>Họ Tên</th>
            <th>Ngày tạo</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Nội dung</th>
            <th>Sản phẩm</th>
            <th>Showroom</th>
            <th>Bài Viết</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        {{-- @dd($contacts) --}}
        @if(isset($contacts) && is_object($contacts))
            @foreach($contacts as $contact)
                <tr>
                    <td>
                        <input type="checkbox" value="{{ $contact->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        {{ $contact->name }}
                    </td>
                    <td>
                        {{ convertDateTime($contact->created_at,'d/m/Y') }}
                    </td>
                    <td>
                        {{ $contact->phone }}
                    </td>
                    <td>
                        @if($contact->email)
                            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        @endif
                    </td>
                    <td>
                        {{ $contact->address }}
                    </td>
                    {{-- The message the visitor typed. Clamped so one long enquiry does not
                         make the whole row unreadable; the full text is in the title. --}}
                    <td style="max-width:320px;">
                        @if($contact->content)
                            <span title="{{ $contact->content }}">{{ \Illuminate\Support\Str::limit($contact->content, 160) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($contact->product_id)
                            <div> {{ isset($contact->products) ? $contact->products->languages->first()->pivot->name : null  }}</div>
                            <div style="color:blue;font-size:12px;">Danh mục: {{ $contact->products->product_catalogues[0]->languages->first()->pivot->name }}</div>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($contact->product_id)
                             {{ isset($contact->posts) ? $contact->posts->languages->first()->pivot->name : null }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if(!$contact->product_id)
                            <div> {{ isset($contact->posts) ? $contact->posts->languages->first()->pivot->name : null }}</div>
                        @else
                            -
                        @endif
                       
                    </td>
                    <td class="text-center"> 
                        <a href="{{ route('contact.delete', $contact->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $contacts->links('pagination::bootstrap-4') }}
