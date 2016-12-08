</br>
<form action="Home.php">
    <fieldset>
        <legend>Type your research</legend>
        <input name="research" type="text" required />
        <select name="option_research">
            <option value="catalog_number">Catalog number</option>
            <option value="product_name">Product name</option>
        </select>
        <input type="checkbox" name="stock" value="In_stock">In Stock
        <br><br>
        <input type="submit" method="get" value="submit" />
    </fieldset>
    </form>

