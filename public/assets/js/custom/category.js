$('[name=meta_keywords]').tagify();

function displaySlug(ele) {
    let $this = ele;
        category = $this.val(),
        lowercaseString = category.toLowerCase(),
        replacedString = lowercaseString.replace(/ /g, '-');
        slug_data = 'https://jaipurjewelleryhouse.com/' + replacedString;
        // $('.category-slug').text('Slug : https://jaipurjewelleryhouse.com/' + replacedString);
        $('.category-slug').val(slug_data);
        $('.SlugBox').show();

}

function editDisplaySlug(ele) {

    let $this = ele;
        editCategory = $this.val(),
        editLowercaseString = editCategory.toLowerCase(),
        editReplacedString = editLowercaseString.replace(/ /g, '-');
        slug_data = 'https://jaipurjewelleryhouse.com/' + editReplacedString;
        // $('.edit-category-slug').text('Slug : https://jaipurjewelleryhouse.com/' + editReplacedString);
        $('.edit-category-slug').val(slug_data);
        $('.oldSlug').hide();
        $('.newSlug').show();
}