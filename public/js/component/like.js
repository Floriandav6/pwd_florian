
export default function () {
    let likeLink = document.querySelector(".js-like-link");
    likeLink.addEventListener('click',onClickLike);

    function onClickLike(e) {
        e.preventDefault();

        const url = this.href,
            buttonlike = this.children[0];

        axios.get(url).then(function (response) {

            let jsLike = document.querySelector('.js-likes');

            jsLike.innerHTML = response.data.like;

            if (buttonlike.classList.contains('far')) {
                buttonlike.classList.replace('far', 'fas');
            } else {
                buttonlike.classList.replace('fas', 'far');
            }
            console.log(response);
        })
    }
}
