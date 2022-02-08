<?php


namespace Magexo\Pos\Console\Command;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magexo\Pos\Model\MagexoposFactory;
 
class Insert extends Command
{
    const INPUT_KEY_NAME ="name";
    const INPUT_KEY_ADDRESS ="address";
    const INPUT_KEY_ISTAXABLE ="istaxable";
    private $posFactory;

    public function __construct(MagexoposFactory $magexoposFactory) {
        $this->magexoposFactory = $magexoposFactory;
        parent::__construct();
    }

    protected function configure() {
        $this->setName("magexo:pos:add")
                ->addArgument(
                               self::INPUT_KEY_NAME,
                               InputArgument::REQUIRED,
                               'Input Name'
                            )
                ->addArgument(
                                self::INPUT_KEY_ADDRESS,
                                InputArgument::REQUIRED,
                                'Input Address'
                            )
                ->addArgument(
                                self::INPUT_KEY_ISTAXABLE,
                                InputArgument::OPTIONAL,
                                "IS/NOT Taxable"
                            );
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $magexopos = $this->magexoposFactory->create();
        $magexopos->setName($input->getArgument(self::INPUT_KEY_NAME));
        $magexopos->setAddress($input->getArgument(self::INPUT_KEY_ADDRESS));
        $magexopos->setIsTaxable($input->getArgument(self::INPUT_KEY_ISTAXABLE));
        $magexopos->save();
        $output->writeln('<info>You have successfully added new POS !</info>');
        $output->writeln ('Name: ' .$input->getArgument(self::INPUT_KEY_NAME));
        $output->writeln ('Address: ' .$input->getArgument(self::INPUT_KEY_ADDRESS));
        $output->writeln ('1=Taxable | 0=Not Taxable: ' .$input->getArgument(self::INPUT_KEY_ISTAXABLE));
        
    }
}
