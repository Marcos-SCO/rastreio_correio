<style type="text/css">
    * {
        padding: 0;
        margin: 0
    }

    body {
        display: flex;
        justify-items: center;
        box-sizing: border-box;
        justify-content: center;
        flex-direction: column;
        margin: 0;
        font-size: 1rem;
        padding: 1rem 2rem;
        font-family: sans-serif
    }

    .track-ul {
        padding: .16rem 0;
        display: flex;
        align-items: center;
        list-style: none;
        border-top: 1px dotted #8A8A8A;
    }

    .track-info {
        color: #8A8A8A;
        width: 100%;
        max-width: 111px
    }

    .track-info li {
        font-size: .77rem;
    }

    .track-message {
        color: #111
    }

    .track-message li {
        font-size: .77rem
    }

    .track-message li b {
        font-size: .72rem
    }

    .track-container {
        width: 100%;
        max-width: 524px;
        margin: auto
    }

    .track-code {
        padding: 1rem 0 1.5rem;
        font-size: .92rem;
    }

    .track-code a,
    .mail-link {
        color: #2196F3;
        text-decoration: none
    }

    .message-sender-info {
        margin-top: 1rem;
        font-size: .7rem;
        line-height: 1.3rem;
        padding: 1rem 0 2rem
    }

    .message-sender-info div {
        margin-top: .3rem
    }

    .status {
        display: flex;
        align-items: center;
        border-top: 1px dotted #8A8A8A;
        padding: 1rem 0 .5rem;
        margin-top: .5rem
    }

    .status span {
        content: 'i';
        padding: .1rem;
        /* background: #76aacf; */
        border-radius: 50%;
        font-size: 1.09rem;
        color: #fff;
        font-weight: 600;
        display: inline-block;
        width: 22px;
        text-align: center;
        margin-right: 1rem;
    }

    .status-container {
        /* display: flex;
        align-items: center;
        position: relative */
    }

    .status-checkMark {
        font-size: 26px;
        color: #fff;
        background: #8cc541;
        padding: .1rem .6rem;
        border-radius: 50%;
        font-weight: bold;
        max-height: 36px;
        margin-top: -1rem;
        margin-right: 1rem
    }

    .status-timeline {
        display: flex;
        flex-grow: 1;
        justify-content: center;
        font-size: .85rem;
        text-align: center;
        padding: 2rem 0;
    }

    .status-timeline p:nth-child(1) {
        font-size: .76rem;
        padding: .7rem 0;
    }

    .status-progress {
        height: 14px;
        background: #0f75bc;
        content: '';
        display: block;
        margin: auto;
        border-radius: 1rem;
        /* clip-path: polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 25% 50%, 0% 0%); */
    }

    .timeline-item {
        margin-right: .5rem;
        width: 100%;
        max-width: 200px;
        position: relative
    }

    /* .timeline-item:last-child::after {
        content: '\2713';
        position: absolute;
        top: -5px;
        right: 1px;
        font-size: 26px;
        color: #fff;
        background: #8cc541;
        padding: .2rem 0.7rem .35rem;
        border-radius: 50%;
        font-weight: bold;
    } */

    .timeline-item:nth-child(2) {
        flex-grow: 2;
    }
</style>
<main>
    <section class="track-container">

        <figure style="padding:.5rem 0">
            <img style="max-width: 100px" src="<?= $_ENV['BASE'] ?>/app/views/rastreio/elasticLogo.png" alt="E-lastic logo">
        </figure>

        <?php if (isset($objStatus)) : ?>
            <div class="status">
                <style type="text/css">
                    .status p {
                        color: <?= $objStatus['color'] ?>
                    }

                    .status span {
                        background: <?= $objStatus['color'] ?>
                    }
                </style>
                <span>i</span>
                <p><?= $objStatus['message'] ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($timeLine)) : ?>
            <section class="status-container">
                <div class="status-timeline">
                    <?php foreach ($timeLine as $time) : ?>
                        <div class="timeline-item">
                            <span class="status-progress"></span>
                            <div class="status-message">
                                <p><?= $time['message'] ?></p>
                                <p><?= $time['date'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <span class="status-checkMark">&#10003;</span>
                </div>
            </section>
        <?php endif; ?>

        <div class="track-code">
            <p>Você pode acompanhar o envio com o código de rastreio: <a href="https://www2.correios.com.br/sistemas/rastreamento/default.cfm" target="_blank"><?= $key ?></a></p>
        </div>
        <?php foreach ($tracks as $data) : ?>
            <ul class="track-ul">
                <div class="track-info">
                    <li><?= $data['date'] ?></li>
                    <li><?= $data['hour'] ?></li>
                    <li><?= $data['location'] ?></li>
                </div>
                <div class="track-message">
                    <li><?= $data['message'] ?></li>
                </div>
            </ul>
        <?php endforeach; ?>

        <div class="message-sender-info">
            <b>Dados de envio</b>
            <div>
                <p>MARCOS DOS SANTOS CARVALHO</p>
                <p><a class="mail-link" href="mailto:marcos_sco@outlook.com">marcos_sco@outlook.com</a></p>
                <p>Tel: (11) 944448798</p>
                <p>BARUERI, SP</p>
            </div>
            <p><br>Falta pouco!<br>Equipe da E-lastic Brasil</p>
        </div>
        <small style="font-size: .65rem">Não responda este e-mail</small>
    </section>
</main>