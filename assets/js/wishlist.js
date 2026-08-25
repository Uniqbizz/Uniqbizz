
    const isWishlistUserLoggedIn =
        <?= $isLoggedIn ? 'true' : 'false' ?>;
    /* =========================================================
    WISHLIST SYSTEM
    ========================================================= */


    /* =========================================================
    GET WISHLIST FROM LOCAL STORAGE
    ========================================================= */

    function getWishlist() {

        try {

            const stored =
                localStorage.getItem('wishlist');

            if (!stored) {
                return [];
            }

            const wishlist =
                JSON.parse(stored);

            if (!Array.isArray(wishlist)) {
                return [];
            }

            return [...new Set(
                wishlist
                    .map(id => String(id).trim())
                    .filter(id => id !== '')
            )];

        } catch (error) {

            // console.error(
            //     'WISHLIST: localStorage error',
            //     error
            // );

            return [];
        }
    }
    //db data
    async function loadWishlistFromDB() {

        if (!isWishlistUserLoggedIn) {
            return [];
        }

        try {

            const response =
                await fetch(
                    'assets/submit/get_user_wishlist.php',
                    {
                        method: 'POST',
                        cache: 'no-store'
                    }
                );


            if (!response.ok) {

                throw new Error(
                    `HTTP ${response.status}`
                );
            }


            const result =
                await response.json();


            if (
                !result ||
                result.status !== true ||
                !Array.isArray(result.data)
            ) {

                return [];
            }


            return [
                ...new Set(
                    result.data
                        .map(id => String(id).trim())
                        .filter(id => id !== '')
                )
            ];

        } catch (error) {

            return [];
        }
    }
    //sync
    async function syncWishlistWithDB() {

        if (!isWishlistUserLoggedIn) {
            return;
        }


        const localWishlist =
            getWishlist();


        const dbWishlist =
            await loadWishlistFromDB();


        const mergedWishlist =
            [
                ...new Set([
                    ...localWishlist,
                    ...dbWishlist
                ])
            ];


        saveWishlist(
            mergedWishlist
        );
    }

    /* =========================================================
    SAVE WISHLIST
    ========================================================= */

    function saveWishlist(wishlist) {

        if (!Array.isArray(wishlist)) {
            wishlist = [];
        }

        wishlist = [...new Set(
            wishlist
                .map(id => String(id).trim())
                .filter(id => id !== '')
        )];

        localStorage.setItem(
            'wishlist',
            JSON.stringify(wishlist)
        );

        updateWishlistCount();
    }


    /* =========================================================
    UPDATE WISHLIST COUNT
    ========================================================= */

    function updateWishlistCount() {

        const count =
            getWishlist().length;

        document
            .querySelectorAll('.wishlistCount')
            .forEach(element => {

                element.textContent = count;

            });
    }


    /* =========================================================
    UPDATE HEART BUTTON
    ========================================================= */

    function updateWishlistButton(button, active) {

        if (!button) {
            return;
        }

        const icon =
            button.querySelector('i');

        if (!icon) {
            return;
        }

        if (active) {

            button.classList.add('active');

            icon.classList.remove(
                'ri-heart-line'
            );

            icon.classList.add(
                'ri-heart-fill'
            );

        } else {

            button.classList.remove('active');

            icon.classList.remove(
                'ri-heart-fill'
            );

            icon.classList.add(
                'ri-heart-line'
            );
        }
    }


    /* =========================================================
    LOAD HEART STATES
    ========================================================= */

    function loadWishlistHeartState() {

        const wishlist =
            getWishlist();

        document
            .querySelectorAll('.wishlist-icon')
            .forEach(button => {

                const packageId =
                    String(
                        button.dataset.packageId || ''
                    ).trim();

                if (!packageId) {
                    return;
                }

                updateWishlistButton(
                    button,
                    wishlist.includes(packageId)
                );

            });
    }


    /* =========================================================
    EMPTY WISHLIST HTML
    ========================================================= */

    function getEmptyWishlistHTML() {

        return `

            <div class="text-center py-5">

                <i class="ri-heart-line text-muted"
                   style="font-size:60px;">
                </i>

                <h5 class="fw-bold mt-3">
                    Your Wishlist is Empty
                </h5>

                <p class="text-muted">
                    Start adding packages you love!
                </p>

            </div>

        `;
    }


    /* =========================================================
    LOADING HTML
    ========================================================= */

    function getWishlistLoadingHTML() {

        return `

            <div class="text-center py-5">

                <div class="spinner-border"
                     role="status">
                </div>

                <p class="text-muted mt-2 mb-0">
                    Loading wishlist...
                </p>

            </div>

        `;
    }


    /* =========================================================
    ERROR HTML
    ========================================================= */

    function getWishlistErrorHTML() {

        return `

            <div class="text-center py-5">

                <i class="ri-error-warning-line text-danger"
                style="font-size:50px;">
                </i>

                <h6 class="fw-bold mt-3">
                    Unable to load wishlist
                </h6>

                <p class="text-muted mb-0">
                    Please try again.
                </p>

            </div>

        `;
    }


    /* =========================================================
    LOAD WISHLIST ITEMS
    ========================================================= */

    async function loadWishlistItems() {

        // console.log(
        //     'WISHLIST: Loading wishlist...'
        // );


        const container =
            document.getElementById(
                'wishlistItems'
            );


        /* -------------------------------------------------------
        CHECK CONTAINER
        ------------------------------------------------------- */

        // if (!container) {

        //     console.error(
        //         'WISHLIST ERROR: #wishlistItems not found'
        //     );

        //     return;
        // }


        /* -------------------------------------------------------
        GET IDS
        ------------------------------------------------------- */

        const wishlist =
            getWishlist();


        // console.log(
        //     'WISHLIST IDs:',
        //     wishlist
        // );


        /* -------------------------------------------------------
        EMPTY
        ------------------------------------------------------- */

        if (wishlist.length === 0) {

            container.innerHTML =
                getEmptyWishlistHTML();

            return;
        }


        /* -------------------------------------------------------
        LOADING
        ------------------------------------------------------- */

        container.innerHTML =
            getWishlistLoadingHTML();


        /* -------------------------------------------------------
        SEND IDS TO PHP
        ------------------------------------------------------- */

        const formData =
            new FormData();


        formData.append(
            'package_ids',
            JSON.stringify(wishlist)
        );


        // console.log(
        //     'WISHLIST: Sending to PHP:',
        //     wishlist
        // );


        try {

            const response =
                await fetch(
                    'assets/submit/get_wishlist.php',
                    {
                        method: 'POST',
                        body: formData,
                        cache: 'no-store'
                    }
                );


            // console.log(
            //     'WISHLIST: HTTP:',
            //     response.status
            // );


            /* ---------------------------------------------------
            HTTP ERROR
            --------------------------------------------------- */

            if (!response.ok) {

                throw new Error(
                    `HTTP ${response.status}`
                );
            }


            /* ---------------------------------------------------
            JSON
            --------------------------------------------------- */

            const result =
                await response.json();


            // console.log(
            //     'WISHLIST PHP RESPONSE:',
            //     result
            // );


            /* ---------------------------------------------------
            PHP ERROR
            --------------------------------------------------- */

            if (
                !result ||
                result.status !== true
            ) {

                // console.error(
                //     'WISHLIST PHP ERROR:',
                //     result?.message
                // );


                container.innerHTML =
                    getWishlistErrorHTML();

                return;
            }


            /* ---------------------------------------------------
            GET PACKAGES
            --------------------------------------------------- */

            const packages =
                Array.isArray(result.data)
                    ? result.data
                    : [];


            /* ---------------------------------------------------
            RENDER
            --------------------------------------------------- */

            renderWishlistItems(
                packages
            );

        } catch (error) {

            // console.error(
            //     'WISHLIST FETCH ERROR:',
            //     error
            // );


            container.innerHTML =
                getWishlistErrorHTML();
        }
    }


    /* =========================================================
    FORMAT PRICE
    ========================================================= */

    function formatWishlistPrice(price) {

        const amount =
            Number(price || 0);


        return amount.toLocaleString(
            'en-IN',
            {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            }
        );
    }


    /* =========================================================
    IMAGE PATH
    ========================================================= */

    function getWishlistImagePath(image) {

        if (!image) {
            return '';
        }

        image = String(image).trim();

        /* -------------------------------------------------------
        FULL URL
        ------------------------------------------------------- */

        if (
            image.startsWith('http://') ||
            image.startsWith('https://')
        ) {
            return image;
        }


        /* -------------------------------------------------------
        REMOVE LEADING SLASHES
        ------------------------------------------------------- */

        image = image.replace(/^\/+/, '');


        /* -------------------------------------------------------
        LOCAL XAMPP
        ------------------------------------------------------- */

        const hostname = window.location.hostname;

        if (
            hostname === 'localhost' ||
            hostname === '127.0.0.1'
        ) {
            return '/ca.uniqbizz.com/' + image;
        }


        /* -------------------------------------------------------
        DEV / LIVE
        ------------------------------------------------------- */

        return '/' + image;
    }


    /* =========================================================
    ESCAPE HTML
    ========================================================= */

    function escapeWishlistHTML(value) {

        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }


    /* =========================================================
    RENDER WISHLIST ITEMS
    ========================================================= */

    function renderWishlistItems(packages) {

        const container =
            document.getElementById(
                'wishlistItems'
            );


        /* -------------------------------------------------------
        CHECK CONTAINER
        ------------------------------------------------------- */

        // if (!container) {

        //     console.error(
        //         'WISHLIST: Container missing during render'
        //     );

        //     return;
        // }


        /* -------------------------------------------------------
        REMOVE DUPLICATES
        ------------------------------------------------------- */

        const uniquePackages = [];

        const seen =
            new Set();


        packages.forEach(packageItem => {

            if (
                !packageItem ||
                packageItem.id === undefined ||
                packageItem.id === null
            ) {
                return;
            }


            const id =
                String(
                    packageItem.id
                ).trim();


            if (!id) {
                return;
            }


            if (!seen.has(id)) {

                seen.add(id);

                uniquePackages.push(
                    packageItem
                );
            }

        });


        /* -------------------------------------------------------
        EMPTY
        ------------------------------------------------------- */

        if (uniquePackages.length === 0) {

            container.innerHTML =
                getEmptyWishlistHTML();

            return;
        }


        /* -------------------------------------------------------
        BUILD HTML
        ------------------------------------------------------- */

        let html = '';


        uniquePackages.forEach(packageItem => {

            /* ---------------------------------------------------
            PACKAGE ID
            --------------------------------------------------- */

            const packageId =
                String(
                    packageItem.id
                ).trim();


            /* ---------------------------------------------------
            PACKAGE NAME
            --------------------------------------------------- */

            const packageName =
                packageItem.package_name ||
                'Package';


            /* ---------------------------------------------------
            PRICE
            --------------------------------------------------- */

            const displayPrice =
                formatWishlistPrice(
                    packageItem.net_price_adult
                );


            /* ---------------------------------------------------
            IMAGE
            --------------------------------------------------- */

            const image =
                getWishlistImagePath(
                    packageItem.cover_image
                );


            /* ---------------------------------------------------
            ESCAPED VALUES
            --------------------------------------------------- */

            const safePackageId =
                escapeWishlistHTML(
                    packageId
                );


            const safePackageName =
                escapeWishlistHTML(
                    packageName
                );

            /* ---------------------------------------------------
            CHECK IF ALREADY SAVED IN DATABASE
            --------------------------------------------------- */

            const isAlreadySaved =
                packageItem.is_saved === true ||
                packageItem.is_saved === 1 ||
                String(packageItem.is_saved) === '1';


            const saveWishlistButton =
                isWishlistUserLoggedIn
                    ? isAlreadySaved
                        ? `
                            <button
                                type="button"
                                class="btn btn-sm text-primary saveWishlist"
                                data-package-id="${safePackageId}"
                                title="Saved"
                                disabled
                            >
                                <i class="ri-checkbox-circle-line"></i>
                            </button>
                        `
                        : `
                            <button
                                type="button"
                                class="btn btn-sm text-success saveWishlist"
                                data-package-id="${safePackageId}"
                                title="Save to account"
                            >
                                <i class="ri-save-line"></i>
                            </button>
                        `
                    : '';
            /* ---------------------------------------------------
            HTML
            --------------------------------------------------- */

            html += `

                <div class="wishlist-item
                            border-bottom
                            pb-3
                            mb-3"
                     data-package-id="${safePackageId}">


                    <div class="d-flex
                                gap-3
                                align-items-center
                                wishlist-package-link"
                         data-package-id="${safePackageId}"
                         style="cursor:pointer;">


                        <!-- IMAGE -->

                        <img
                            src="${image}"
                            alt="${safePackageName}"
                            class="rounded"
                            style="
                                width:90px;
                                height:70px;
                                object-fit:cover;
                                flex-shrink:0;
                            "
                        >


                        <!-- DETAILS -->

                        <div class="flex-grow-1">

                            <h6 class="fw-bold mb-1">
                                ${safePackageName}
                            </h6>


                            <div class="fw-bold">

                                <span>
                                    ₹
                                </span>

                                ${displayPrice}

                            </div>

                        </div>


                        <!-- SAVE + REMOVE -->

                        <div class="d-flex align-items-center gap-1">

                            ${saveWishlistButton}

                            <button
                                type="button"
                                class="btn btn-sm text-danger removeWishlist"
                                data-package-id="${safePackageId}"
                                title="Remove from wishlist"
                            >
                                <i class="ri-delete-bin-line"></i>
                            </button>

                        </div>


                    </div>

                </div>

            `;

        });


        /* -------------------------------------------------------
        INSERT
        ------------------------------------------------------- */

        container.innerHTML =
            html;


        // console.log(
        //     'WISHLIST: Rendered:',
        //     uniquePackages.length
        // );
    }


    /* =========================================================
    CLICK HANDLER
    ========================================================= */

    document.addEventListener(
    'click',
    async function (event) {


            /* =====================================================
            1. PACKAGE HEART
            ===================================================== */

            const heart =
                event.target.closest(
                    '.wishlist-icon'
                );


            if (heart) {

                event.preventDefault();
                event.stopPropagation();


                const packageId =
                    String(
                        heart.dataset.packageId || ''
                    ).trim();


                // if (!packageId) {

                //     console.error(
                //         'WISHLIST: Package ID missing'
                //     );

                //     return;
                // }


                let wishlist =
                    getWishlist();


                const index =
                    wishlist.indexOf(
                        packageId
                    );


                /* -------------------------------------------------
                ADD
                ------------------------------------------------- */

                if (index === -1) {

                    wishlist.push(
                        packageId
                    );


                    updateWishlistButton(
                        heart,
                        true
                    );


                    // console.log(
                    //     'WISHLIST: Added:',
                    //     packageId
                    // );

                }


                /* -------------------------------------------------
                REMOVE
                ------------------------------------------------- */

                else {

                    wishlist.splice(
                        index,
                        1
                    );


                    updateWishlistButton(
                        heart,
                        false
                    );


                    // console.log(
                    //     'WISHLIST: Removed:',
                    //     packageId
                    // );
                }


                saveWishlist(
                    wishlist
                );


                return;
            }


            /* =====================================================
            2. REMOVE FROM WISHLIST
            ===================================================== */

            const removeButton =
                event.target.closest(
                    '.removeWishlist'
                );


            if (removeButton) {

                event.preventDefault();
                event.stopPropagation();


                const packageId =
                    String(
                        removeButton.dataset.packageId || ''
                    ).trim();


                if (!packageId) {
                    return;
                }


                // console.log(
                //     'WISHLIST: Removing:',
                //     packageId
                // );


                /* -------------------------------------------------
                REMOVE FROM LOCAL STORAGE
                ------------------------------------------------- */

                let wishlist =
                    getWishlist();


                wishlist =
                    wishlist.filter(
                        id =>
                            String(id).trim() !== packageId
                    );


                saveWishlist(
                    wishlist
                );


                /* -------------------------------------------------
                UPDATE HEARTS
                ------------------------------------------------- */

                document
                    .querySelectorAll(
                        '.wishlist-icon'
                    )
                    .forEach(heart => {

                        const heartId =
                            String(
                                heart.dataset.packageId || ''
                            ).trim();


                        if (
                            heartId === packageId
                        ) {

                            updateWishlistButton(
                                heart,
                                false
                            );

                        }

                    });


                /* -------------------------------------------------
                RELOAD WISHLIST
                ------------------------------------------------- */

                loadWishlistItems();


                return;
            }

            /* =====================================================
            3. SAVE WISHLIST
            ===================================================== */

            const saveButton =
                event.target.closest('.saveWishlist');

            if (saveButton) {

                event.preventDefault();
                event.stopPropagation();


                /* -------------------------------------------------
                CHECK LOGIN
                ------------------------------------------------- */

                if (!isWishlistUserLoggedIn) {
                    return;
                }


                /* -------------------------------------------------
                PACKAGE ID
                ------------------------------------------------- */

                const packageId =
                    String(
                        saveButton.dataset.packageId || ''
                    ).trim();


                if (!packageId) {
                    return;
                }


                /* -------------------------------------------------
                PREVENT DOUBLE CLICK
                ------------------------------------------------- */

                if (saveButton.dataset.saving === '1') {
                    return;
                }

                saveButton.dataset.saving = '1';
                saveButton.disabled = true;


                /* -------------------------------------------------
                ICON
                ------------------------------------------------- */

                const icon =
                    saveButton.querySelector('i');


                if (icon) {

                    icon.classList.remove(
                        'ri-save-line',
                        'ri-checkbox-circle-line'
                    );

                    icon.classList.add(
                        'ri-loader-4-line'
                    );
                }


                /* -------------------------------------------------
                FORM DATA
                ------------------------------------------------- */

                const formData =
                    new FormData();

                formData.append(
                    'package_id',
                    packageId
                );


                /* -------------------------------------------------
                AJAX
                ------------------------------------------------- */

                try {

                    const response =
                        await fetch(
                            'assets/submit/save_wishlist.php',
                            {
                                method: 'POST',
                                body: formData,
                                cache: 'no-store'
                            }
                        );


                    if (!response.ok) {

                        throw new Error(
                            `HTTP ${response.status}`
                        );
                    }


                    const result =
                        await response.json();


                    /* -------------------------------------------------
                    SUCCESS
                    ------------------------------------------------- */

                    if (
                        result &&
                        result.status === true
                    ) {

                        /* ---------------------------------------------
                        CHANGE TO SAVED
                        --------------------------------------------- */

                        if (icon) {

                            icon.classList.remove(
                                'ri-loader-4-line',
                                'ri-save-line'
                            );

                            icon.classList.add(
                                'ri-checkbox-circle-line'
                            );
                        }


                        saveButton.classList.remove(
                            'text-success'
                        );

                        saveButton.classList.add(
                            'text-primary'
                        );


                        saveButton.title =
                            'Saved';


                        /*
                        Keep disabled because it is already saved.
                        */

                        saveButton.disabled = true;

                        saveButton.dataset.saving = '0';


                        return;
                    }


                    /* -------------------------------------------------
                    PHP ERROR
                    ------------------------------------------------- */

                    if (icon) {

                        icon.classList.remove(
                            'ri-loader-4-line'
                        );

                        icon.classList.add(
                            'ri-save-line'
                        );
                    }


                    saveButton.dataset.saving = '0';
                    saveButton.disabled = false;


                } catch (error) {

                    // console.error(
                    //     'WISHLIST SAVE ERROR:',
                    //     error
                    // );


                    /* ---------------------------------------------
                    RESTORE BUTTON
                    --------------------------------------------- */

                    if (icon) {

                        icon.classList.remove(
                            'ri-loader-4-line'
                        );

                        icon.classList.add(
                            'ri-save-line'
                        );
                    }


                    saveButton.dataset.saving = '0';
                    saveButton.disabled = false;
                }


                return;
            }
            /* =====================================================
            4. WISHLIST PACKAGE REDIRECT
            ===================================================== */

            const wishlistPackage =
                event.target.closest(
                    '.wishlist-package-link'
                );


            if (wishlistPackage) {

                event.preventDefault();
                event.stopPropagation();


                const packageId =
                    String(
                        wishlistPackage.dataset.packageId || ''
                    ).trim();


                if (!packageId) {

                    // console.error(
                    //     'WISHLIST: Package ID missing for redirect'
                    // );

                    return;
                }


                // console.log(
                //     'WISHLIST: Opening package:',
                //     packageId
                // );


                window.location.href =
                    `tour-details.php?pacId=${encodeURIComponent(packageId)}`;


                return;
            }


            /* =====================================================
            5. WISHLIST HEADER BUTTON
            ===================================================== */

            const wishlistButton =
                event.target.closest(
                    '[data-bs-target="#wishlistOffcanvas"]'
                );


            if (wishlistButton) {

                // console.log(
                //     'WISHLIST: Header button clicked'
                // );


                /*
                Do NOT use preventDefault()
                or stopPropagation() here.

                Bootstrap needs the click event
                to open the offcanvas.
                */

                loadWishlistItems();


                return;
            }

        }
    );


    /* =========================================================
    DOM READY
    ========================================================= */

    document.addEventListener(
        'DOMContentLoaded',
        async function () {

            // console.log(
            //     'WISHLIST: Initializing'
            // );


            /* ---------------------------------------------------
            COUNT
            --------------------------------------------------- */

            updateWishlistCount();


            /* ---------------------------------------------------
            HEARTS
            --------------------------------------------------- */

            loadWishlistHeartState();

            
            /*
            |--------------------------------------------------------------------------
            | SYNC DATABASE WISHLIST
            |--------------------------------------------------------------------------
            */

            if (isWishlistUserLoggedIn) {

                await syncWishlistWithDB();

                updateWishlistCount();

                loadWishlistHeartState();
            }

        }
    );


    /* =========================================================
    AJAX / DYNAMIC PACKAGE SUPPORT
    ========================================================= */

    window.refreshWishlistUI = function () {

        updateWishlistCount();

        loadWishlistHeartState();

    };

