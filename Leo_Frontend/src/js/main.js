import buzcayaLogo from "/Logo Circle.png";
import "../scss/styles.scss";
import * as bootstrap from "bootstrap";

document.querySelector(
  "#app"
).innerHTML = ` <div class="container bg-dark text-light">
<h1>Heading 1</h1>
    <h2>Heading 2</h2>
    <h3>Heading 3</h3>
    <h4>Heading 4</h4>
    <h5>Heading 5</h5>
    <h6>Heading 6</h6>

    <p>This is a paragraph. <a href="#">This is a link</a>.</p>

    <div class="card text-bg-primary mb-3 p-2" style="max-width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Primary card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
    </div>


    <ul>
        <li>List item 1</li>
        <li>List item 2</li>
        <li>List item 3</li>
    </ul>

    <ol>
        <li>Ordered list item 1</li>
        <li>Ordered list item 2</li>
        <li>Ordered list item 3</li>
    </ol>

    <table class="table table-primary table-responsive">
        <thead>
            <tr>
            <th>Header 1</th>
            <th>Header 2</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Data 1</td>
            <td>Data 2</td>
        </tr>
        </tbody>
    </table>

    <button class="btn btn-primary">Button</button>

    <form>
        <label for="input">Input:</label>
        <input type="text" id="input" name="input" placeholder="Heeeeee" class="form-control bg-primary text-dark">
        <div class="form-check">
          <input type="radio" class="form-check-input"><label class="form-check-label">Leoforeio</label>
        </div>
        <div class="form-check">
          <input type="checkbox" class="form-check-input"><label class="form-check-label">Leoforeio</label>
        </div>
        <input type="submit" class="btn btn-outline-light" value="Submit">
    </form>

    <div class="alert alert-warning alert-dismissable fade show" role="alert">
        <h1>Danger</h1>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
`;
