<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body bg-white">
                <form method="POST" action="{{ route('ventas.store') }}" role="form" enctype="multipart/form-data">
                    @csrf

                    @include('venta.form')

                </form>
            </div>
        </div>
    </div>
</section>