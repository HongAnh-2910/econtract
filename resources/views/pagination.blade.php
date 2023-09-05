@if ($paginator->hasPages())
    <div class="col-12">
        <ul class="list-unstyled d-flex justify-content-end mt-2">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination__icon--page mr-3 d-flex align-items-center disabled"><span><i class="fas fa-angle-left"></i></span></li>
            @else

                <li class="pagination__icon--page mr-3 d-flex align-items-center"><a href="{{ request()->fullUrlWithQuery(['page' => (int)request()->page > 2 ? ((int)request()->page - 1) : null]) }}" class="icon-pre"
                        rel="prev">
                        <i class="fas fa-angle-left"></i></a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @php
                            $urlArray = explode('http', $url);
                            $urlParams = request()->input('status');
                            $finalUrl = $url;
                            if (count($urlArray) <= 1) {
                                $finalUrl = url()->current() . $url;
                            }
                            if (isset($urlParams)) {
                                $finalUrl .= '&status=' . $urlParams;
                            }
                        @endphp
                        <!--  Use three dots when current page is away from end.  -->
                        @if ($paginator->currentPage() > 4 && $page === 2)
                            <li class="pagination__icon--page mr-2 text-center disabled"><span>...</span></li>
                        @endif


                        @if ($page == $paginator->currentPage())
                            <li class="pagination__number--page mr-2 text-center active"><span>{{ $page }}</span></li>
                        @elseif ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2
                            || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2 ||
                            $page === $paginator->lastPage() || $page === 1)
                            <li class="pagination__number--size mr-2 text-center"><a class="d-flex w-100 h-100 justify-content-center align-items-center" href="{{ $finalUrl }}">{{ $page }}</a></li>
                        @endif

                        {{-- @if ($page == $paginator->currentPage())
                            <li class="pagination__number--page mr-2 text-center active">
                                <span>{{ $page }}</span>
                            </li>
                        @else
                            @php
                                $urlArray = explode('http', $url);
                                $urlParams = request()->input('status');
                                $finalUrl = $url;
                                if (count($urlArray) <= 1) {
                                    $finalUrl = url()->current() . $url;
                                }
                                if (isset($urlParams)) {
                                    $finalUrl .= '&status=' . $urlParams;
                                }
                            @endphp
                            <li class="pagination__number--size mr-2 text-center"><a
                                    href="{{ $finalUrl }}">{{ $page }}</a></li>
                        @endif --}}

                        <!--  Use three dots when current page is away from end.  -->
                        @if ($paginator->currentPage() < $paginator->lastPage() - 3 && $page === $paginator->lastPage() - 1)
                            <li class="pagination__icon--page mr-2 text-center disabled"><span>...</span></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination__icon--page ml-1 mr-3 d-flex align-items-center"><a href="{{ request()->fullUrlWithQuery(['page' => (int)request()->page >= 2 ? (int)request()->page + 1 : 2]) }}"
                        class="icon-pre" rel="next">
                        <i class="fas fa-angle-right"></i></a></li>
            @else
                <li class="pagination__icon--page mr-3 disabled d-flex align-items-center"><span><i class="fas fa-angle-right"></i></span></li>
            @endif
        </ul>
    </div>
@endif
