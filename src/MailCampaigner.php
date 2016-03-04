<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use League\Csv\Reader;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MailCampaigner extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mail:campaign';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'send newsletter mail';
	protected $file;

	/**
	 * Create a new command instance.
	 * @param Filesystem $file
	 */
	public function __construct(Filesystem $file)
	{

		parent::__construct();
		$this->file = $file;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$file=$this->argument('file');
		$mails = $this->mailFromFile($file);
		$c=count($mails);
		print_r("total : ".$c."\n");
		$emails=[];
		$start=$this->option('start');
		$end=$this->option('end');
		$view=$this->option('view');
		$senderAddr=$this->option('sender_address');
		$senderName=$this->option('sender_name');
		$subject=$this->option('subject');
		foreach(range($start,$end) as $num){
			if($num > count($mails)-1){
				$this->info("\n Maximum reached");
				break;
			}
			print_r($num.',');
			$this->sendMail(trim($mails[$num]));
		}
		$this->info("\n All done");
	}
	public function sendMail($email)
	{
		\URL::forceRootUrl(config('app.url'));
		\Mail::send($view, [], function ($m) use ($email,$subject,$senderAddr) {
			$m->to($email)->subject($subject);
			$m->from($senderAddr, $senderName);
		});
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['file', InputArgument::REQUIRED, 'A file to be extracted.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['subject', 'sub', InputOption::VALUE_REQUIRED, 'subject of mail', 'Hello'],
			['from_address', 'f', InputOption::VALUE_REQUIRED, 'Address of sender', 'Hello'],
			['from_name', 'n', InputOption::VALUE_REQUIRED, 'Name of sender'],
			['view', 'v', InputOption::VALUE_REQUIRED, 'View to use'],
			['start', 's', InputOption::VALUE_OPTIONAL, 'number to start from.', 0],
			['end', 'e', InputOption::VALUE_OPTIONAL, 'number to end with', 500],			
		];
	}

	/**
	 * @param $file
	 * @return array
	 */
	private function mailFromFile($file)
	{
		$reader = Reader::createFromPath(storage_path($file),'r');
		$reader->setOffset(1);
		$result = $reader->fetchColumn(0);
		$mails = iterator_to_array($result, false);
////		$mails=['vmayaki@techneeks.com.ng','vmeregini@techneeks.com.ng','nohadoma@techneeks.com.ng'];
// 		$rawMails=file_get_contents(storage_path()."/".$file);
		// $rawMails=preg_replace('/\s+|(<|>)/S', '', $rawMails);
// 		$mails=explode("\n",trim(trim($rawMails)));
// 		$mails=array_filter($mails);
		return $mails;
	}

}
