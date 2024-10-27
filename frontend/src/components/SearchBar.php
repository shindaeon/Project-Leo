<?php
function SearchBar($placeholder, $icon)
{
    echo <<<HTML
        <div class='input-group bg-dark'>
            <input id="searchBar" type='text' class='form-control bg-secondary text-light border-0 p-3' placeholder='$placeholder' aria-label='Search' aria-describedby='searchBar'>
            <button class='input-group-text bg-primary text-dark border-0 ps-4 pe-4' id='btn_search'>$icon</button>
        </div>

    HTML;
}
