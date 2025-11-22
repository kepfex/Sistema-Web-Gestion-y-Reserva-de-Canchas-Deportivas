<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateComponentTests extends Command
{
    protected $signature = 'make:component-tests {--all : Generate tests for all Livewire components} {--force : Overwrite existing tests}';

    protected $description = 'Generate test skeletons for Livewire components under app/Livewire';

    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle(): int
    {
        $base = app_path('Livewire');

        if (! $this->files->isDirectory($base)) {
            $this->error('No Livewire components directory found at app/Livewire');
            return 1;
        }

        $phpFiles = $this->files->allFiles($base);

        $count = 0;

        foreach ($phpFiles as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $content = $this->files->get($file->getPathname());

            // extract namespace and class
            if (! preg_match('/namespace\s+([^;]+);/i', $content, $nsMatch)) {
                continue;
            }

            if (! preg_match('/class\s+(\w+)/i', $content, $classMatch)) {
                continue;
            }

            $namespace = trim($nsMatch[1]);
            $class = trim($classMatch[1]);
            $fqcn = $namespace . '\\' . $class;

            // Build a test class name based on namespace parts after Livewire
            $parts = explode('\\', $namespace);
            $idx = array_search('Livewire', $parts);
            $suffix = [];
            if ($idx !== false) {
                $suffix = array_slice($parts, $idx + 1);
            }
            $suffix[] = $class;
            $testName = implode('', array_map('ucfirst', $suffix)) . 'FeatureTest';

            $testPath = base_path('tests/Feature/' . $testName . '.php');

            if ($this->files->exists($testPath) && ! $this->option('force')) {
                $this->info('Skipped existing: ' . $testPath);
                continue;
            }

            $stub = $this->buildTestStub($fqcn, $testName);

            $this->files->put($testPath, $stub);
            $this->info('Generated: ' . $testPath);
            $count++;
        }

        $this->info("Generated $count test(s).");
        return 0;
    }

    protected function buildTestStub(string $componentFqcn, string $testClassName): string
    {
        $componentShort = addslashes($componentFqcn);
        $now = date('Y');

        return <<<PHP
<?php

namespace Tests\\Feature;

use Tests\\TestCase;
use Illuminate\\Foundation\\Testing\\RefreshDatabase;
use Livewire\\Livewire;

use {$componentShort};

class {$testClassName} extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists({$componentShort}::class));
    }

    public function test_guest_redirected_placeholder()
    {
        // TODO: Implement: ensure guest cannot access admin routes related to this component
        // e.g. \$this->get(route('admin.some.route'))->assertRedirect(route('login'));
        \$this->markTestIncomplete('Implement guest redirect test for {$componentShort}');
    }

    public function test_component_basic_render_placeholder()
    {
        // TODO: Implement: mount the Livewire component as an authenticated user and assert behavior
        // Example:
        // \$user = \App\\Models\\User::factory()->create();
        // \$this->actingAs(\$user);
        // Livewire::test({$componentShort}::class)->assertSee('...');
        \$this->markTestIncomplete('Implement render test for {$componentShort}');
    }

    public function test_create_update_delete_placeholders()
    {
        // TODO: Implement create/update/delete tests following Arrange, Act, Assert pattern.
        \$this->markTestIncomplete('Implement CRUD tests for {$componentShort}');
    }
}

PHP;
    }
}
