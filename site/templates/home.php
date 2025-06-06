<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title><?= $site->title(); ?></title>
  <meta name="description" content="<?= $site->site_description(); ?>">
  <meta name="keywords" content="<?= $site->keywords(); ?>">

  <link rel="icon" href="./../../../../assets/favicon/favicon.png">

  <meta name="robots" content="index">

  <?= css(['assets/css/site.css', '@auto']); ?>
</head>

<body>
    <main>
        <div class="container">
            <!-- <div class="lettering"></div> -->

            <div class="logo-container delay">
                <div class="logo">
                    <div class="logo-image"></div>
                </div> 
            </div>
            <div class="brush-container delay">
                <div class="brush">
                    <div class="brush-image type-m" onclick="bioOnOff()"></div>
                    <div class="brush-title type-m">
                        <?= $site->title() ?>
                    </div>
                    <div class="brush-text type-s">
                        <?= $site->bio() ?>
                    </div>
                </div>
            </div>

            <?php $visualCounter = 0; ?>
            <?php foreach($page->children()->listed() as $project): ?>
                <div class="project-container delay" onclick="openModal(<?= $visualCounter ?>)">
                    <div class="project-code type-s">
                        <?= $project->title() ?>
                    </div>
                    <?php foreach ($project->visuals_desktop()->toStructure() as $item): ?>
                        <div class="project-visual">
                            <?php if ($item->thumb()->toFile()->type() === 'image'): ?>
                                <div class="project-visual-image glitch-img" style="background-image: url('<?= $item->thumb()->toFile()->url() ?>')"></div>
                            <?php endif ?>
                        </div>
                        <?php $visualCounter++ ?>
                    <?php endforeach ?>

                    
                </div>
            <?php endforeach ?>

            <?php $visualCounter = 0; ?>
            <?php foreach($page->children()->listed() as $project): ?>
                <?php foreach ($project->visuals_desktop()->toStructure() as $item): ?>
                    <div class="modal" onclick="closeModal(<?= $visualCounter ?>)">
                        <div class="modal-code type-m">
                            <?= $project->codice() ?>
                        </div>
                        <div class="modal-info type-m">
                            <?= $item->titolo() ?>, <?= $item->year() ?>, <?= $item->place() ?>
                        </div>
                        <?php if ($item->full()->toFile()->type() === 'image'): ?>
                            <img src="<?= $item->full()->toFile()->url() ?>" alt="<?= $item->full()->toFile()->alt() ?>" loading="lazy" class="modal-content" >
                        <?php endif ?>
                        <?php if ($item->full()->toFile()->type() === 'video'): ?>
                            <video autoplay loop muted playsinline class="modal-content" onclick="closeModal(<?= $visualCounter ?>)">
                                <source src="<?= $item->full()->toFile()->url() ?>" type="video/mp4" />
                            </video>
                        <?php endif ?>
                    </div>
                    <div class="modal-background" onclick="closeModal(<?= $visualCounter ?>)"></div>
                    <?php $visualCounter++ ?>
                <?php endforeach ?>
            <?php endforeach ?>         
        </div>
    </main>
</body>

<script>
    var brush = document.querySelector(".brush");
    var brushTitle = document.querySelector(".brush-title");
    var brushText = document.querySelector(".brush-text");
    var count = 1;
    
    function bioOnOff(){
        if (count % 2 === 0) {
            brush.classList.remove("bio-on");
            brushTitle.classList.remove("text-on");
            brushText.classList.remove("text-on");
            count = count + 1;
        } else {
            brush.classList.add("bio-on");
            brushTitle.classList.add("text-on");
            brushText.classList.add("text-on");
            count = count + 1;
        }
    }
</script>    

<script>
    var modal = document.querySelectorAll(".modal");
    var modalBg = document.querySelectorAll(".modal-background");

    function openModal(n){
        modal[n].classList.add("modal-active");
        modalBg[n].classList.add("modal-background-active");
    }

    function closeModal(n){
        modal[n].classList.remove("modal-active");
        modalBg[n].classList.remove("modal-background-active");
    }
</script>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
      const projects = Array.from(document.querySelectorAll(".delay"));

      // Shuffle the array using Fisher-Yates algorithm
      for (let i = projects.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [projects[i], projects[j]] = [projects[j], projects[i]];
      }

      // Fade in each project in random order
      projects.forEach((project, index) => {
        setTimeout(() => {
          project.style.opacity = 1;
        }, index * 150); // 200ms between each
      });
    }, 150); // Delay the start by 200ms
  });
</script>

<!-- <script>
    document.addEventListener("DOMContentLoaded", () => {
        var lettering = document.querySelector(".lettering");
        setTimeout(() => {
            lettering.style.opacity = 0;
        }, 100); // small delay to allow DOM paint before fading
    });
</script> -->

<script>
document.addEventListener("DOMContentLoaded", () => {
  const containers = document.querySelectorAll(".project-container");

containers.forEach(container => {
  const visuals = container.querySelectorAll(".project-visual");
  if (visuals.length <= 1) return;

  let currentIndex = Math.floor(Math.random() * visuals.length);
  visuals.forEach((v, i) => {
    v.style.display = i === currentIndex ? "block" : "none";
  });

  // ✅ Store index on the container
  container.dataset.currentIndex = currentIndex;

  const rotateVisual = () => {
    let nextIndex;
    do {
      nextIndex = Math.floor(Math.random() * visuals.length);
    } while (nextIndex === currentIndex);

    visuals[currentIndex].style.display = "none";
    visuals[nextIndex].style.display = "block";
    currentIndex = nextIndex;

    // ✅ Update the data attribute
    container.dataset.currentIndex = currentIndex;

    const nextInterval = Math.floor(Math.random() * 4000) + 2000;
    setTimeout(rotateVisual, nextInterval);
  };

  const initialInterval = Math.floor(Math.random() * 4000) + 2000;
  setTimeout(rotateVisual, initialInterval);
});

});
</script>

<!-- jQuery -->
<script
	src="https://code.jquery.com/jquery-2.2.4.min.js"
    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
	crossorigin="anonymous">
</script>

<!-- mgGlitch -->
<?= js("assets/js/mgGlitch.min.js")?>
    
<!-- mgGlitch -->
<script>
	$( function() {
		$( ".glitch-img" ).mgGlitch({
			destroy : false, // set 'true' to stop the plugin
            glitch: true, // set 'false' to stop glitching
            scale: true, // set 'false' to stop scaling
            blend : true, // set 'false' to stop glitch blending
            blendModeType : 'hue', // select blend mode type
            glitch1TimeMin : 600, // set min time for glitch 1 elem
            glitch1TimeMax : 900, // set max time for glitch 1 elem
            glitch2TimeMin : 10, // set min time for glitch 2 elem
            glitch2TimeMax : 115, // set max time for glitch 2 elem
            zIndexStart : 0, // because of absolute position, set z-index base value
		});
	});
</script>