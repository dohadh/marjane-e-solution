<div class="card border-left-{{ $color }} shadow h-100 py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-{{ $color }} text-uppercase mb-1">
                    {{ $title }}
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ number_format($count) }} 
                    @if($unit)
                        <small class="text-sm text-muted">{{ $unit }}</small>
                    @endif
                </div>
            </div>
            <div class="col-auto">
                <i class="fas fa-{{ $icon }} fa-2x text-{{ $color }} opacity-50"></i>
            </div>
        </div>
    </div>
</div>