const userBtn = document.querySelector('#user-btn');
userBtn.addEventListener('click', function() {
    const userBox = document.querySelector('.profile-detail');
    userBox.classList.toggle('active');
});

const toggle = document.querySelector('#toggle-btn');
toggle.addEventListener('click', function() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const deleteBtn = document.getElementById('delete-product-btn');
    const deleteImageBtn = document.getElementById('delete-image-btn');
    
    // Delete Product Confirmation
    if(deleteBtn && form) {
        deleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this product!",
                icon: "warning",
                buttons: ["Cancel", "Yes, delete it!"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'delete';
                    hiddenInput.value = '1';
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            });
        });
    }
    
    if(deleteImageBtn && form) {
        deleteImageBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            swal({
                title: "Delete product image?",
                text: "This will remove the image from your product.",
                icon: "warning",
                buttons: ["Cancel", "Delete Image"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'delete_image';
                    hiddenInput.value = '1';
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            });
        });
    }
    window.addEventListener('pagehide', function(e) {
        console.log('This is getting activated');
        const oldImageInput = document.querySelector('input[name="old_image"]');
        const newImageInput = document.querySelector('input[name="image"]');
        const productIdInput = document.querySelector('input[name="product_id"]');
    
        if(oldImageInput && productIdInput) {
            const hasOldImage = oldImageInput.value.trim() !== '';
            const hasNewImage = newImageInput && newImageInput.files.length > 0;
            
            if(!hasOldImage && !hasNewImage) {
                // Use URLSearchParams instead of FormData (better compatibility)
                const params = new URLSearchParams();
                params.append('set_default_image', '1');
                params.append('product_id', productIdInput.value);
                
                navigator.sendBeacon('../include/set_default_image.php', params);
                
            }
        }
    });
});