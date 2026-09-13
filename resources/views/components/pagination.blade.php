@if ($paginator->hasPages())
    <nav class="site-pagination" aria-label="Paginação">
        @if (method_exists($paginator, 'total'))
            <p class="site-pagination__summary">
                A mostrar {{ $paginator->firstItem() }} a {{ $paginator->lastItem() }} de {{ $paginator->total() }} resultados
            </p>
        @endif
        <ul class="pagination">
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                @if ($paginator->onFirstPage())
                    <span class="page-link" aria-disabled="true">« Anterior</span>
                @else
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">« Anterior</a>
                @endif
            </li>
            @foreach ($elements ?? [] as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @else
                    @foreach ($element as $page => $url)
                        <li class="page-item {{ $page === $paginator->currentPage() ? 'active' : '' }}">
                            @if ($page === $paginator->currentPage())
                                <span class="page-link" aria-current="page" aria-label="Página {{ $page }}">{{ $page }}</span>
                            @else
                                <a class="page-link" href="{{ $url }}" aria-label="Ir para a página {{ $page }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach
            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                @if ($paginator->hasMorePages())
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Seguinte »</a>
                @else
                    <span class="page-link" aria-disabled="true">Seguinte »</span>
                @endif
            </li>
        </ul>
    </nav>
@endif
