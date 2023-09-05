@foreach ($names as $key => $value)
    <div
        class="col-10 modal__contract--list--contract pl-4 mb-3 border rounded d-flex justify-content-between">
        <div class="modal__contract--list--item d-flex">
            <div class="modal__contract--list--icon d-flex align-items-center pr-2">
                <img width="27px" height="25px"
                    src="{{ get_extension_thumb($type[$key]) }}">
            </div>
            <div class="">
                <span class="modal__contract--list-title">{{ $value }}</span>
                <span class="d-block modal__contract--list-size">{{ number_format($size[$key], 0, '', '.') }}
                    KB</span>
            </div>
        </div>
        <div class="dropdown d-flex align-items-center px-2 list__users--color--cursor">
            <div class="dropdown-toggle" id="dropdownDataFile" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i style="font-size: 20px" class="fas fa-ellipsis-v"></i>
            </div>
            <div style="width: 60px" class="dropdown-menu" aria-labelledby="dropdownDataFile">
                <form method="POST">
                    <button class="dropdown-item" style="font-size: 15px ; outline: none">
                        <i class="fas fa-window-restore"></i>
                        Tác vụ 1
                    </button>
                </form>
                <button data-toggle="modal" data-target="#exampleModal1" class="dropdown-item" type="submit"
                    data-toggle="tooltip" style="font-size: 15px; outline: none"><i class="fa fa-trash"></i> Tác vụ 2
                </button>
            </div>
        </div>
    </div>
@endforeach
