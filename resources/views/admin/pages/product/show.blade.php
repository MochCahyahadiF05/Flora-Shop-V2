<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h5 id="show-name"></h5>
                <p><strong>Category:</strong> <span id="show-category"></span></p>
                <p><strong>Description:</strong></p>
                <p id="show-description"></p>
                <p><strong>Price:</strong> Rp <span id="show-price"></span></p>
                <p><strong>Stock:</strong> <span id="show-stock"></span></p>

                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="carousel-images">
                        <!-- gambar akan ditambahkan dari JS -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
