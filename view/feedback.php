<!doctype html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Feedbacker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/layout/css/main.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div id="logo" class="col-6">
                    <span>Feedbacker</span>
                </div>
                <?php if ($admin){
                    echo '
                    <div id="logout" class="col-6">
                    <form action="" method="post">
                        <button type="submit" class="btn btn-danger" name="logout">Вийти</button>
                      </form>
                    </div>';
                }else{
                    echo '
                    <div id="admin" class="col-6">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">Login as Admin</button>
                    </div>';
                } ?>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <label for="sort">Сортувати по:</label>
                <select name="sort" id="sort" class="form-select">
                    <option value="name">Імені користувача</option>
                    <option value="email">Email</option>
                    <option value="date" selected>Даті відгуку</option>
                </select>
            </div>
            <div id="responses-block">
                <?php foreach ($responses as $respons):?>
                    <div id="<?php echo $respons['id']; ?>" class="response mb-3">
                        <div class="row">
                            <div class="col-3">
                                <span><?php echo $respons['name'];?></span><br>
                                <span class="text-secondary"><?php echo $respons['email'];?></span><br>
                            </div>
                            <div class="col-9">
                                <span class="response-message"><?php echo $respons['message'];?>
                                    <?php if($admin){ echo '<button onclick="openEditMessage(this)" class="btn btn-secondary btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                                        echo ' <button onclick="deleteResponse(this)" class="btn btn-danger btn-sm btn-edit"><i class="fa fa-times-circle" aria-hidden="true"></i></button>';} ?>
                                </span>
                                <br>
                                <span class="text-secondary message-time"><?php echo date("d.m H:i", strtotime($respons['date'])); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="div-load text-center mt-3">
                <button id="load-more" class="btn btn-danger btn-center">Загрузити ще</button>
            </div>
        </div>
        <div class="container mt-3">
            <div class="form-response">
                <form action="" method="post">
                    <h2>Залишити відгук</h2>
                    <label for="name">Ваше ім'я:</label>
                    <input type="text" name="name" required class="form-control">
                    <label for="email">Ваш email:</label>
                    <input type="email" name="email" required class="form-control">
                    <label for="message">Ваше повідомлення:</label>
                    <textarea name="message" id="message" cols="30" rows="10" required class="form-control"></textarea>
                    <button name="submit" class="btn btn-success mt-3" type="submit">Відправити</button>
                    <button class="btn btn-warning mt-3 btn-preview" type="button">Попередній перегляд</button>
                </form>
            </div>
            <div class="preview mt-3">

            </div>
        </div>
    </main>
    <!-- Modal login-->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Увійдіть в акаунт</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="login">Логін:</label>
                        <input name="login" type="text" class="form-control">
                        <label for="password">Пароль:</label>
                        <input name="password" type="password" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                        <button type="submit" name="auth" class="btn btn-primary">Увійти</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal edit-->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Редагування</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="user"></span>
                        <label for="edit-message">Повідомлення:</label>
                        <textarea name="edit-message" id="edit-message" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                        <button onclick="editResponse()" id="btn-edit" type="button" name="edit" data-bs-dismiss="modal" class="btn btn-primary">Зберегти</button>
                    </div>
                </div>
        </div>
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    &copy;2021 Всі права захищені
                </div>
            </div>
        </div>
    </footer>
    <script src="https://use.fontawesome.com/a42ba82aaf.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="/layout/js/app.js"></script>
</body>
</html>