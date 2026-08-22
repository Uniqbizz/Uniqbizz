<?php
// includes/wishlist_offcanvas.php
?>

<div class="offcanvas offcanvas-end"
     tabindex="-1"
     id="wishlistOffcanvas"
     aria-labelledby="wishlistOffcanvasLabel">

    <div class="offcanvas-header border-bottom">

        <h5 class="offcanvas-title fw-bold"
            id="wishlistOffcanvasLabel">

            <i class="ri-heart-fill text-danger me-2"></i>
            My Wishlist

        </h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close">
        </button>

    </div>

    <div class="offcanvas-body p-3">

        <div id="wishlistItems">

            <div class="text-center py-5">

                <i class="ri-heart-line"
                   style="font-size:60px;">
                </i>

                <h5 class="fw-bold mt-3">
                    Your Wishlist is Empty
                </h5>

                <p class="text-muted">
                    Start adding packages you love!
                </p>

            </div>

        </div>

    </div>

</div>