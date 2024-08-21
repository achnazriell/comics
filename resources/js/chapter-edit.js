// Function to delete chapter with one click
function oneClickDelete(chapterId) {
    if (confirm('Are you sure you want to delete this chapter?')) {
        document.getElementById('delete-form-' + chapterId).submit();
    }
}

// Function to add image input to existing chapter
document.getElementById('addImageToExistingChapter').addEventListener('click', function() {
    const wrapper = document.getElementById('chapterImagesWrapper');
    const newInput = document.createElement('div');
    newInput.classList.add('chapter-image-input', 'mb-4');
    newInput.innerHTML = `
        <label class="block text-sm font-medium text-gray-700">Chapter Images</label>
        <input type="file" name="chapter_images[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    `;
    wrapper.appendChild(newInput);
});

// Function to add a new chapter form
document.getElementById('addChapter').addEventListener('click', function() {
    const wrapper = document.getElementById('newChaptersWrapper');
    const index = wrapper.children.length;
    const newChapter = document.createElement('div');
    newChapter.classList.add('chapter-image-input', 'mb-4');
    newChapter.innerHTML = `
        <h4 class="text-sm font-medium text-gray-700 mb-2">Chapter ${index + 1}</h4>
        <label class="block text-sm font-medium text-gray-700">Chapter Image</label>
        <input type="file" name="new_chapters[][image]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    `;
    wrapper.appendChild(newChapter);
});
