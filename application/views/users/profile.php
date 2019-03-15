<div class="row row-cards">
        <div class="card col-sm-4 col-lg-4">
          <div class="card-header">
            <h3 class="card-title">Mon Profil</h3>
          </div>
          <div class="card">
          <div class="card-body text-center" style="padding-top:25%">
            <img class="card-profile-img" width="120" height="100" src="<?php echo session_data('photo')!=NULL?assets_url('images/profil').'/'.session_data('photo'):assets_url('images/profil/noprofil.jpg') ?>">
            <div class="text-center" style="font-family: 'Times New Roman'">
                   <h3><?php echo mb_strtoupper(session_data('name')) ?></h3>
                                <h4>Service: <?php echo session_data('groupName') ?></h4>
                                <h4>Role: <?php echo session_data('roleName') ?></h4>
                                <h4>Email: <?php echo session_data('email') ?></h4>
                                <br /><br/>
                            </div>
          </div>
        </div>
        </div>
    
    
    
    <div class="col-lg-8">
    <div class="card">
        <div class="col-sm-10 offset-sm-1">
                <ul class="nav nav-tabs" id="myTab" role="tablist" >
                        <li class="nav-item">
                            <a href="#profile" class="nav-link2 active" id="home-tab" data-toggle="tab" aria-controls="home" aria-selected="true" >Modifier mon profil</a>
                        </li>
                        <li class="nav-item">
                            <a href="#pass" class="nav-link2" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-selected="false" >Modifier mon mot de passe</a>
                        </li>
                      </ul>
                      
                     
        </div>
        <div class="card-block ">
      
            <div class="col-sm-12 " id="display">
                <div class="container">
                    <section style="padding-bottom: 50px; padding-top: 50px;">
                        <div class="row">
                                <div class="col-sm-8 offset-sm-2">
                                <?php if (isset($error)) { ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" onclick="$(this).parrent().hide()"></button>
                                <?php echo $error ?>
                        </div>
                      <?php } ?>
                                        <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="home-tab">
                                                        <form method="post" enctype="multipart/form-data" action="<?php echo site_url('utilisateur/modifyProfil') ?>">
                                                                <div class="form-group">
                                
                                                                <div class="form-group">
                                                                        <div class="form-label">Photo de profil</div>
                                                                        <div>
                                                                            <input type="file" name="photo">
                                                                        </div>
                                                                    </div>
                                                                <div class="form-group row">
                                                                    <label for="nom" class="required">Nom et prénom</label>
                                                                    <div>
                                                                        <input type="text" id="nom" name="nom" value="<?php echo session_data('name') ?>" class="form-control">
                                                                        <?php echo form_error("nom") ?>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="email" class="required">Email</label>
                                                                    <div>
                                                                        <input type="text" id="email" value="<?php echo session_data('email') ?>"  name="email" class="form-control">
                                                                        <?php echo form_error("email") ?>
                                                                    </div>
                                                                </div>
                                                               
                                                                    <br><br>
                                                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                                                </div>
                                                            </form>
                                                </div>
                                                <div class="tab-pane fade" id="pass" role="tabpanel" aria-labelledby="profile-tab">
                                                        <form method="post">
                                                                <div class="form-group">
                                
                                                                <div class="form-group row">
                                                                    <label for="oldP" class="required">Entrer l'ancien mot de passe</label>
                                                                    <div>
                                                                        <input type="password" id="oldP" name="oldP" value="<?php echo set_value('oldP') ?>" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="newP" class="required">Entrer le nouveau mot de passe</label>
                                                                    <div>
                                                                        <input type="password" id="newP"  name="newP" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="rP" class="required">Confirmer le nouveau mot de passe</label>
                                                                    <div>
                                                                        <input type="password" id="rP" name="rP" class="form-control" />
                                                                    </div>
                                                                </div>
                                                                
                                                                    <br><br>
                                                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                                                </div>
                                                            </form>
                                                </div>
                                        </div>
                               
                                </div>
                        </div>
                        <!-- ROW END -->
    
    
                    </section>
                    <!-- SECTION END -->
                </div>
    
            </div>

        </div>
    </div>
    </div>
    
    </div>
    <script type="text/javascript">
    require(['fileuploader'], function(){
        $(document).ready(function() {


            $('input[name="photo"]').fileuploader({
                limit: 1, // limit of the files {Number}
                maxSize: 5, // files maximal size in Mb {Number}
                fileMaxSize: 2, // file maximal size in Mb {Number}
                extensions: ['jpg', 'jpeg', 'png'], // allowed extensions or types {Array}
                changeInput: '<div class="fileuploader-input">' +
                '<div class="fileuploader-input-caption">' +
                '<span>${captions.feedback}</span>' +
                '</div>' +
                '<div class="fileuploader-input-button">' +
                '<span>${captions.button}</span>' +
                '</div>' +
                '</div>',
                inputNameBrackets: true,
                theme: 'default',
                thumbnails: {
                    box: '<div class="fileuploader-items">' +
                    '<ul class="fileuploader-items-list"></ul>' +
                    '</div>',
                    boxAppendTo: null,
                    item: '<li class="fileuploader-item">' +
                    '<div class="columns">' +
                    '<div class="column-thumbnail">${image}</div>' +
                    '<div class="column-title">' +
                    '<div title="${name}">${name}</div>' +
                    '<span>${size2}</span>' +
                    '</div>' +
                    '<div class="column-actions">' +
                    '<a class="fileuploader-action fileuploader-action-remove" title="Retirer"><i></i></a>' +
                    '</div>' +
                    '</div>' +
                    '<div class="progress-bar2">${progressBar}<span></span></div>' +
                    '</li>',
                    item2: '<li class="fileuploader-item">' +
                    '<div class="columns">' +
                    '<a href="${data.url}" target="_blank">' +
                    '<div class="column-thumbnail">${image}</div>' +
                    '<div class="column-title">' +
                    '<div title="${name}">${name}</div>' +
                    '<span>${size2}</span>' +
                    '</div>' +
                    '</a>' +
                    '<div class="column-actions">' +
                    '<a href="${file}" class="fileuploader-action fileuploader-action-download" title="Télécharger" download><i></i></a>' +
                    '</div>' +
                    '</div>' +
                    '</li>',
                    itemPrepend: false,
                    removeConfirmation: true,
                    startImageRenderer: true,
                    synchronImages: true,
                    canvasImage: {
                        width: null,
                        height: null
                    },
                    _selectors: {
                        list: '.fileuploader-items-list',
                        item: '.fileuploader-item',
//                        start: '.fileuploader-action-start',
                        retry: '.fileuploader-action-retry',
                        remove: '.fileuploader-action-remove'
                    },
                    beforeShow: function(parentEl, newInputEl, inputEl) {
                        // your callback here
                    },
                    onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {
//                        if(item.choosed)
//                            item.html.find('.column-actions').prepend(
//                                '<a class="fileuploader-action fileuploader-action-start" title="Start upload"><i></i></a>'
//                            );
                    },
                    onItemRemove: function(itemEl, listEl, parentEl, newInputEl, inputEl) {
                        itemEl.children().animate({'opacity': 0}, 200, function() {
                            setTimeout(function() {
                                itemEl.slideUp(200, function() {
                                    itemEl.remove();
                                });
                            }, 100);
                        });
                    },
                    onImageLoaded: function(itemEl, listEl, parentEl, newInputEl, inputEl) {
                        // your callback here
                    },
                },
                addMore: false,
                files:[],
                clipboardPaste: 2000,
                listInput: true,
                enableApi: true,
                dialogs: {
                    alert: function(text) {
                        return alert(text);
                    },
                    confirm: function(text, callback) {
                        confirm(text) ? callback() : null;
                    }
                },
                captions: {
                    button: function(options) { return 'Choisir ' + (options.limit == 1 ? 'le Fichier' : 'les Fichiers'); },
                    feedback: function(options) { return 'Choisir ' + (options.limit == 1 ? 'l\'image' : 'les images') + ' à attacher'; },
                    feedback2: function(options) { return options.length + ' ' + (options.length > 1 ? ' fichiers ont été' : ' fichiers a été') + ' chosis'; },
                    drop: 'Déposez les fichiers ici pour télécharger',
                    paste: '<div class="fileuploader-pending-loader"><div class="left-half" style="animation-duration: ${ms}s"></div><div class="spinner" style="animation-duration: ${ms}s"></div><div class="right-half" style="animation-duration: ${ms}s"></div></div> Coller un fichier, cliquez ici pour annuler.',
                    removeConfirmation: 'Êtes-vous sûr de vouloir supprimer ce fichier?',
                    errors: {
                        filesLimit: 'Only ${limit} files are allowed to be uploaded.',
                        filesType: 'Seuls les fichiers ${limit} peuvent être téléchargés.',
                        fileSize: '${name} est trop grand! Veuillez choisir un fichier jusqu\'à ${fileMaxSize} MB.',
                        filesSizeAll: 'Les fichiers que vous avez choisis sont trop grands! Veuillez télécharger des fichiers jusqu\'à ${maxSize} Mo.',
                        fileName: 'Le fichier portant le nom ${name} est déjà sélectionné.',
                        folderUpload: 'Vous n\'êtes pas autorisé à télécharger des dossiers.'
                    }
                }
            });
           
        });
    });
</script>