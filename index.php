<html>
<head>
    <link rel='stylesheet' href='/style.css' type='text/css' media='all'/>
</head>
<body>
<?php
    include 'Document.php';

    if (isset($_GET['reset'])) {
        file_put_contents('states.db', '');
        file_put_contents('payed.db', '');
    }

    $document = new Document();

    $stages = array_values($document->getProgress());
?>
<div class="bg-gray-f6 md:h-full">
    <div class="container mx-auto mydashboard--content relative">
        <h1>Future Power of Attorney</h1>
        <br />
        <?php foreach (DocumentState::getCallToActions($document->getCurrentStatus()) as $cta) { ?>
            <a href="/?<?php echo http_build_query($cta['query']); ?>" class="btn bg-dark-teal text-white">
                <?php echo $cta['title']; ?>
            </a>
        <?php } ?>
        <a href="/?reset=1" class="btn bg-viva-red text-white">Reset</a>
        <br /><br />
        <div class="tabs-panel card--proces h-full overflow-y-scroll is-active">
            <div class="p-4 bg-white rounded-t-xl h-full pt-2 pb-20 flex flex-col md:px-2 md:py-0 md:pb-12">
                <span class="handle text-dark-teal w-full flex items-center justify-center mb-2 md:hidden">
                    <svg class="fill-current h-6 w-6 transform rotate-90" viewBox="0 0 32 32" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.475 23.475a3.571 3.571 0 105.05 5.05l-5.05-5.05zM26 16l2.525 2.525a3.572 3.572 0 000-5.05L26 16zM18.525 3.475a3.571 3.571 0 10-5.05 5.05l5.05-5.05zm0 25.05l10-10-5.05-5.05-10 10 5.05 5.05zm10-15.05l-10-10-5.05 5.05 10 10 5.05-5.05z"></path>
                    </svg></span>
                <div class="process-accordion flex flex-col xs:overflow-y-auto">
                    <div>
                        <?php foreach ($stages as $index => $stage) { ?>
                            <div class="proces-item w-full relative step1 <?php if ($stage['reached']) { ?>visited<?php } ?> <?php if (!isset($stages[$index + 1]) || !$stages[$index + 1]['reached']) { ?>last<?php } ?>">
                                <div class="proces-circle h-4 w-4 rounded-full absolute left-0 top-0 mt-5"></div>
                                <div class="border-l border-gray-300 pl-4 ml-2">
                                    <div class="py-2 md:px-2">
                                        <div class="shadow-xs w-full bg-gray-f6 text-gray-69 rounded-sm">
                                            <div class="proces-item--box cursor-pointer p-2 xs:text-sm text-base rounded-sm md:px-4 <?php if (!empty($stage['active'])) { ?>bg-dark-teal text-white<?php } else { ?>bg-gray-f6 text-gray-69<?php } ?>">
                                                <?php echo DocumentStage::getTitle($stage['stage']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>