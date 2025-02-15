<div class="d-flex justify-content-center">
    <div class="form-check">
        <input class="btn-check" type="radio" name="cat_{{ $category }}" id="{{ $category }}_1" value="1" {{ old("cat_$category") == 1 ? 'checked' : '' }}>
        <label class="btn p-4 fs-4" for="{{ $category }}_1">
            1
        </label>
    </div>

    <div class="form-check">
        <input class="btn-check" type="radio" name="cat_{{ $category }}" id="{{ $category }}_2" value="2" {{ old("cat_$category") == 2 ? 'checked' : '' }}>
        <label class="btn p-4 fs-4" for="{{ $category }}_2">
            2
        </label>
    </div>

    <div class="form-check">
        <input class="btn-check" type="radio" name="cat_{{ $category }}" id="{{ $category }}_3" value="3" {{ old("cat_$category") == 3 ? 'checked' : '' }}>
        <label class="btn p-4 fs-4" for="{{ $category }}_3">
            3
        </label>
    </div>

    <div class="form-check">
        <input class="btn-check" type="radio" name="cat_{{ $category }}" id="{{ $category }}_4" value="4" {{ old("cat_$category") == 4 ? 'checked' : '' }}>
        <label class="btn p-4 fs-4" for="{{ $category }}_4">
            4
        </label>
    </div>

    <div class="form-check">
        <input class="btn-check" type="radio" name="cat_{{ $category }}" id="{{ $category }}_5" value="5" {{ old("cat_$category") == 5 ? 'checked' : '' }}>
        <label class="btn p-4 fs-4" for="{{ $category }}_5">
            5
        </label>
    </div>
</div>
