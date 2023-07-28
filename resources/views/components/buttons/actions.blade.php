<div class="btn-group btn-group-sm">
    @if(!empty($show))
        <a href="{{ $show }}" class="btn btn-primary d-inline-flex justify-content-center align-items-center">
            <i class="bi bi-eye"></i>
        </a>
    @endif
    @if(!empty($edit))
        <a href="{{ $edit }}" class="btn btn-success d-inline-flex justify-content-center align-items-center">
            <i class="bi bi-pencil-square"></i>
        </a>
    @endif
    @if(!empty($archive))
        <a href="{{ $archive }}" class="btn btn-warning d-inline-flex justify-content-center align-items-center">
            <i class="bi bi-archive"></i>
        </a>
    @endif
    @if(!empty($unarchive))
        <a href="{{ $unarchive }}" class="btn btn-outline-success d-inline-flex justify-content-center align-items-center">
            <i class="bi bi-archive"></i>
        </a>
    @endif
    @if(!empty($delete))
        <a href="{{ $delete }}" onclick="return confirm('Удалить запись?')" class="btn btn-danger d-inline-flex justify-content-center align-items-center">
            <i class="bi bi-trash"></i>
        </a>
    @endif
</div>
