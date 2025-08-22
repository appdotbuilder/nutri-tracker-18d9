import * as React from "react";
import { cn } from "@/lib/utils";

const Select = ({ 
  value, 
  onValueChange, 
  children 
}: { 
  value: string;
  onValueChange: (value: string) => void;
  children: React.ReactNode;
}) => {
  const [isOpen, setIsOpen] = React.useState(false);
  const [selectedValue, setSelectedValue] = React.useState(value);

  React.useEffect(() => {
    setSelectedValue(value);
  }, [value]);

  const handleSelect = (newValue: string) => {
    setSelectedValue(newValue);
    onValueChange(newValue);
    setIsOpen(false);
  };

  return (
    <div className="relative">
      {React.Children.map(children, (child) => {
        if (React.isValidElement(child)) {
          return React.cloneElement(child, {
            // @ts-expect-error - Dynamic props for Select components
            isOpen,
            setIsOpen,
            selectedValue,
            handleSelect,
          });
        }
        return child;
      })}
    </div>
  );
};

const SelectValue = ({ 
  placeholder, 
  selectedValue 
}: { 
  placeholder?: string;
  selectedValue?: string;
}) => {
  return <span>{selectedValue || placeholder}</span>;
};

const SelectTrigger = React.forwardRef<
  HTMLButtonElement,
  React.ButtonHTMLAttributes<HTMLButtonElement> & {
    isOpen?: boolean;
    setIsOpen?: (open: boolean) => void;
    selectedValue?: string;
  }
>(({ className, children, isOpen, setIsOpen, ...props }, ref) => (
  <button
    ref={ref}
    type="button"
    className={cn(
      "flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-1 focus:ring-ring disabled:cursor-not-allowed disabled:opacity-50 [&>span]:line-clamp-1",
      className
    )}
    onClick={() => setIsOpen && setIsOpen(!isOpen)}
    {...props}
  >
    {children}
    <svg
      className="h-4 w-4 opacity-50"
      fill="none"
      stroke="currentColor"
      viewBox="0 0 24 24"
    >
      <path
        strokeLinecap="round"
        strokeLinejoin="round"
        strokeWidth={2}
        d="M19 9l-7 7-7-7"
      />
    </svg>
  </button>
));
SelectTrigger.displayName = "SelectTrigger";

const SelectContent = ({ 
  className, 
  children, 
  isOpen, 
  ...props 
}: React.HTMLAttributes<HTMLDivElement> & {
  isOpen?: boolean;
}) => {
  if (!isOpen) return null;

  return (
    <div
      className={cn(
        "absolute z-50 min-w-[8rem] overflow-hidden rounded-md border bg-popover p-1 text-popover-foreground shadow-md",
        "top-full mt-1 w-full",
        className
      )}
      {...props}
    >
      {children}
    </div>
  );
};

const SelectItem = ({ 
  className, 
  children, 
  value, 
  handleSelect,
  ...props 
}: React.HTMLAttributes<HTMLDivElement> & {
  value: string;
  handleSelect?: (value: string) => void;
}) => (
  <div
    className={cn(
      "relative flex w-full cursor-default select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground",
      className
    )}
    onClick={() => handleSelect && handleSelect(value)}
    {...props}
  >
    {children}
  </div>
);

export {
  Select,
  SelectValue,
  SelectTrigger,
  SelectContent,
  SelectItem,
};