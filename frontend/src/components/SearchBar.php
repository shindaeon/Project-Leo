<?php
function SearchBar($placeholder, $icon)
{
    echo "
        <div class='input-group bg-dark p-3'>
            <input type='text' class='form-control bg-secondary text-dark border-0' placeholder='$placeholder' aria-label='Search' aria-describedby='searchBar'>
            <button class='input-group-text bg-primary text-dark border-0' id='searchBar'>$icon</button>
        </div>

    ";
}
