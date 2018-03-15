<?php
class Gallery extends Controller {
  public function index() {
    $this->albums();
  }

  public function albums() {
    $title="Gallerie";
    $this->loader->load('albums',['title'=>$title,$album=>$album_id,'albums'=>$this->gallery->albums()]);
  }

  public function albums_new() {
$this->loader->load('albums_new');
  }

  public function albums_create() {
    try {
      $album_name = filter_input(INPUT_POST, 'album_name');
      $this->gallery->create_album($album_name);
      /* Créer l'album avec le modèle. */
      header('Location: /index.php/gallery/albums'); /* redirection du client vers la liste des albums. */
    } catch (Exception $e) {
      $this->loader->load('albums_new', ['title'=>'Création d\'un album', 'error_message' => $e->getMessage()]);
    }
  }

  public function albums_delete($album_id) {
    try {
      $id = filter_var($album_id);
      $this->gallery->delete_album($album_id);
    } catch (Exception $e) { }
    header('Location: /index.php/gallery/albums');
  }

  public function albums_show($album_id) {
    $this->loader->load('albums_show',
      ['title'=>$this->gallery->album_name($album_id),
      'album'=>$album_id,
      'photos'=>$this->gallery->photos($album_id)]);
  }

  public function photos_new($album_id) {
    $this->loader->load('photos_new', ['album_name'=>$album_id]);

  }

    public function photos_add($album_id) {
      try {
        $album_id = filter_var($album_id);
        $this->gallery->check_if_album_exists($album_name);

      } catch (Exception $e) { header("Location: /index.php"); }

      try {
        $photo_name = filter_input(INPUT_POST, 'photo_name');
        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
          throw new Exception('Vous devez choisir une photo.');
        }
        $this->gallery->add_photo($album_id, $photo_name, $_FILES['photo']['tmp_name']);
        /* TODO : demander au modèle d'ajouter la photo dont le nom 'temporaire' du fichier
                  est donné par $_FILES['photo']['tmp_name']; */
                  header("location:/index.php/gallery/albums_show/$album_id");
        /* TODO : rediriger l'utilisateur vers l'affichage des photos de l'album,
                  c'est-à-dire vers l'URL "/index.php/gallery/albums_show/$album_name"; */
      } catch (Exception $e) {
        $this->loader->load('photos_new', ['album_name'=>$album_name,
                            'title'=>"Ajout d'une photo dans l'album $album_name",
                                   'error_message' => $e->getMessage()]);
      }
    }

    public function photos_delete($album_name, $photo_name) {
      try {
        $album_name = filter_var($album_name);
        $this->gallery->delete_photo($album_name,$photo_name);
          header("location:/index.php/gallery/albums_show/$album_name");
      } catch (Exception $e) { header("Location: /index.php"); }
    }


    public function photos_show($album_name, $photo_name) {
      try {
        $album_name = filter_var($album_name);
        $photo_name = filter_var($photo_name);
        $this->loader->load('photos_show', ['title'=>"$album_name / $photo_name",
            'album'=>$album_id,
            'photo'=>$this->gallery->photo($album_name,$photo_name),
        ]);
      } catch (Exception $e) {
        header("Location: /index.php");
      }
    }

}
