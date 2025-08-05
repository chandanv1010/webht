@if ($model->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @php
            $prevPageUrl = ($model->currentPage() > 1) ? str_replace('?page=', '/trang-', $model->previousPageUrl()).config('apps.general.suffix') : null;
        @endphp
        @if ($prevPageUrl)
            <li class="page-item"><a class="page-link previous" href="{{ $prevPageUrl }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 320 512" class="fill-light w-3 h-3"><path d="M15 239c-9.4 9.4-9.4 24.6 0 33.9L207 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L65.9 256 241 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0z"></path></svg></a></li>
        @else
            <li class="page-item disabled">
                <span class="page-link previous">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 320 512" class="fill-light w-3 h-3"><path d="M15 239c-9.4 9.4-9.4 24.6 0 33.9L207 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L65.9 256 241 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0z"></path></svg>
                </span>
            </li>
        @endif

        {{-- Pagination Links --}}
        @foreach ($model->getUrlRange(max(1, $model->currentPage() - 2), min($model->lastPage(), $model->currentPage() + 2)) as $page => $url)
            @php
                $paginationUrl = str_replace('?page=', '/trang-', $url).config('apps.general.suffix');
                $paginationUrl = ($page == 1) ? str_replace('/trang-'.$page, '', $paginationUrl) : $paginationUrl;
            @endphp
            <li class="page-item {{ ($page == $model->currentPage()) ? 'active' : '' }}"><a class="page-link page-number" href="{{ $paginationUrl }}">{{ $page }}</a></li>
        @endforeach

        {{-- Next Page Link --}}
        @php
            $nextPageUrl = ($model->hasMorePages()) ? str_replace('?page=', '/trang-', $model->nextPageUrl()).config('apps.general.suffix') : null;
        @endphp
        @if ($nextPageUrl)
            <li class="page-item">
                <a class="page-link next" href="{{ $nextPageUrl }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 320 512" class="fill-light rotate-180 w-3 h-3"><path d="M15 239c-9.4 9.4-9.4 24.6 0 33.9L207 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L65.9 256 241 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0z"></path></svg>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 320 512" class="fill-light rotate-180 w-3 h-3"><path d="M15 239c-9.4 9.4-9.4 24.6 0 33.9L207 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L65.9 256 241 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0z"></path></svg>
                </span>
            </li>
        @endif
    </ul>
@endif
