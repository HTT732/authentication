<nav class="navbar navbar-light float-right justify-content-end">
    <form id="searchForm" action="{{ route('admin.user.search') }}" class="d-flex" method="get">
        @csrf
        <input class="form-control me-2 float-start w-auto" type="search" placeholder="Search" value="{{ $oldInput ?? !empty($oldInput) }}" name="value" aria-label="Search" required>
        <button class="btn btn-outline-primary ml-1" type="submit"><i class="material-icons search">&#xe8b6;</i></button>
    </form>
</nav>
