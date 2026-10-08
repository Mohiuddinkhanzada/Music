document.addEventListener("DOMContentLoaded", () => {


  document
    .querySelectorAll("[data-year-options], #filterEra")
    .forEach((select) => {

      if (typeof ERAS === "undefined") {
        return;
      }

      ERAS.forEach((era) => {

        const option = document.createElement("option");

        option.value = era.label;
        option.textContent = era.label;

        select.appendChild(option);

      });

    });



  const menuButton =
    document.querySelector(".mobile-menu");

  const sidebar =
    document.querySelector(".sidebar");


  if (menuButton && sidebar) {

    menuButton.addEventListener("click", () => {

      sidebar.classList.toggle("open");

    });

  }



  document.addEventListener(
    "click",
    async (event) => {

      const rateButton =
        event.target.closest(".rate-btn");


      if (!rateButton) {
        return;
      }


      event.preventDefault();
      event.stopPropagation();


      const itemId =
        rateButton.dataset.itemId || "";


      const itemType =
        rateButton.dataset.itemType || "";


      if (!itemId || !itemType) {

        console.error(
          "Rating ID or type is missing."
        );

        return;
      }


      if (
        rateButton.dataset.ratingLoading === "true"
      ) {

        return;
      }


      rateButton.dataset.ratingLoading =
        "true";

      rateButton.disabled = true;


      const formData =
        new FormData();


      formData.append(
        "item_id",
        itemId
      );


      formData.append(
        "item_type",
        itemType
      );


      try {

        const response =
          await fetch(
            "./rating.php",
            {
              method: "POST",
              body: formData
            }
          );


        if (!response.ok) {

          throw new Error(
            "Rating request failed. Status: " +
            response.status
          );

        }


        const data =
          await response.json();


        console.log(
          "Rating response:",
          data
        );



        if (
          data.success === true &&
          data.rated === true
        ) {

          rateButton.textContent = "★";

          rateButton.style.color =
            "#1ed760";

          rateButton.title =
            "Rated";

        }



        else if (
          data.success === true &&
          data.rated === false
        ) {

          rateButton.textContent = "☆";

          rateButton.style.color = "";

          rateButton.style.borderColor = "";

          rateButton.title =
            itemType === "video"
              ? "Rate this video"
              : "Rate this song";

        }



        else {

          console.error(
            "Rating failed:",
            data.message ||
            "Unknown rating error."
          );

        }


      } catch (error) {

        console.error(
          "Rating error:",
          error
        );

      } finally {

        rateButton.disabled = false;

        rateButton.dataset.ratingLoading =
          "false";

      }

    },

    true
  );



  const searchInput =
    document.querySelector("#siteSearch");

  const searchMenu =
    document.querySelector("#searchMenu");


  if (searchInput && searchMenu) {

    searchInput.addEventListener(
      "focus",
      () => {

        searchMenu.classList.add("open");

      }
    );


    searchInput.addEventListener(
      "input",
      () => {

        const query =
          searchInput.value
            .trim()
            .toLowerCase();


        if (typeof ARTISTS === "undefined") {
          return;
        }


        const matches =
          ARTISTS
            .filter((artist) =>
              artist.name
                .toLowerCase()
                .includes(query)
            )
            .slice(0, 6);


        searchMenu.innerHTML =
          matches.length

            ? matches
                .map(
                  (artist) => `
                    <button
                      onclick="location.href='artist.php?id=${artist.id}'">

                      <strong>
                        ${artist.name}
                      </strong>

                      <small>
                        ${artist.language} artist
                      </small>

                    </button>
                  `
                )
                .join("")

            : `
                <button
                  onclick="location.href='music.php'">

                  Search all music

                </button>
              `;


        searchMenu.classList.add("open");

      }
    );


    document.addEventListener(
      "click",
      (event) => {

        if (
          !event.target.closest(".search")
        ) {

          searchMenu.classList.remove(
            "open"
          );

        }

      }
    );

  }



  document
    .querySelectorAll("[data-filter-link]")
    .forEach((button) => {

      button.addEventListener(
        "click",
        () => {

          const params =
            new URLSearchParams();


          const language =
            document.querySelector(
              "#filterLanguage"
            )?.value || "";


          const genre =
            document.querySelector(
              "#filterGenre"
            )?.value || "";


          const artist =
            document.querySelector(
              "#filterArtist"
            )?.value || "";


          const era =
            document.querySelector(
              "#filterEra"
            )?.value || "";


          if (language) {

            params.set(
              "language",
              language
            );

          }


          if (genre) {

            params.set(
              "genre",
              genre
            );

          }


          if (artist) {

            params.set(
              "artist",
              artist
            );

          }


          if (era) {

            params.set(
              "era",
              era
            );

          }


          const queryString =
            params.toString();


          location.href =
            "music.php" +
            (
              queryString
                ? `?${queryString}`
                : ""
            );

        }
      );

    });



  document
    .querySelectorAll("[data-play]")
    .forEach((button) => {

      button.addEventListener(
        "click",
        () => {

          playTrack(
            button.dataset.play
          );

        }
      );

    });

});



function bindPlayButtons(container) {

  if (!container) {
    return;
  }


  container
    .querySelectorAll("[data-play]")
    .forEach((button) => {

      button.addEventListener(
        "click",
        () => {

          playTrack(
            button.dataset.play
          );

        }
      );

    });

}



function playTrack(id) {

  if (typeof TRACKS === "undefined") {
    return;
  }


  const track =
    TRACKS.find(
      (item) => item.id === id
    );


  if (!track) {
    return;
  }


  const player =
    document.querySelector("#player");


  if (!player) {
    return;
  }


  const image =
    player.querySelector(".now img");


  const title =
    player.querySelector(".now strong");


  const artist =
    player.querySelector(".now span");


  const progress =
    player.querySelector(".progress i");


  const mainPlay =
    player.querySelector(".main-play");


  if (image) {
    image.src = track.cover;
  }


  if (title) {
    title.textContent =
      track.title;
  }


  if (artist) {
    artist.textContent =
      track.artist;
  }


  if (progress) {
    progress.style.width =
      "18%";
  }


  if (mainPlay) {
    mainPlay.textContent =
      "Ⅱ";
  }


  setTimeout(() => {

    if (progress) {

      progress.style.width =
        "46%";

    }

  }, 400);

}