<div class="product-form">
    <h2 class="text-xl font-bold mb-4">Add Product</h2>
    
    <form action="updateProduct.php" method="POST" class="space-y-4">
        <!-- Product Name -->
        <div>
            <label for="productName" class="block text-sm font-medium">Product Name</label>
            <input type="text" id="productName" name="productName"
                   class="border p-2 w-full rounded" placeholder="Enter product name" required>
        </div>

        <!-- Price -->
        <div>
            <label for="price" class="block text-sm font-medium">Price</label>
            <input type="number" id="price" name="price"
                   class="border p-2 w-full rounded" placeholder="Enter price" required>
        </div>

        <!-- Stock -->
        <div>
            <label for="stock" class="block text-sm font-medium">Stock</label>
            <input type="number" id="stock" name="stock"
                   class="border p-2 w-full rounded" placeholder="Enter stock" required>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium">Description</label>
            <textarea id="description" name="description"
                      class="border p-2 w-full rounded" rows="3" placeholder="Enter description"></textarea>
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add Products
            </button>
        </div>
    </form>
</div>
